<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class SecurityHardeningTest extends TestCase
{
    use RefreshDatabase;

    public function test_security_headers_are_present_without_breaking_public_pages(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertHeader('X-Content-Type-Options', 'nosniff')
            ->assertHeader('X-Frame-Options', 'DENY')
            ->assertHeader('Referrer-Policy', 'strict-origin-when-cross-origin')
            ->assertHeader('Content-Security-Policy', "base-uri 'self'; object-src 'none'; frame-ancestors 'none'; form-action 'self'")
            ->assertHeaderMissing('Strict-Transport-Security');
    }

    public function test_captcha_is_an_uncached_png_and_is_not_embedded_as_text(): void
    {
        $this->withSession(['captcha_code' => 'LEGACY'])
            ->get(route('contact'))
            ->assertOk()
            ->assertDontSee('LEGACY')
            ->assertDontSee('<span class="captcha">', false)
            ->assertSee(route('contact.captcha'), false);

        $response = $this->get(route('contact.captcha'));
        $response->assertOk()->assertHeader('Content-Type', 'image/png');
        $this->assertStringStartsWith("\x89PNG", $response->getContent());
        $this->assertStringContainsString('no-store', $response->headers->get('Cache-Control'));
    }

    public function test_failed_captcha_cannot_be_reused(): void
    {
        $this->withSession(['captcha_code' => 'AB12'])
            ->post(route('contact.send'), [...$this->contactPayload(), 'captcha' => 'WRONG'])
            ->assertSessionHasErrors('captcha');

        $this->post(route('contact.send'), [...$this->contactPayload(), 'captcha' => 'AB12'])
            ->assertSessionHasErrors('captcha');
        $this->assertDatabaseCount('contacts', 0);
    }

    public function test_contact_endpoint_limits_repeated_submissions(): void
    {
        for ($i = 0; $i < 5; $i++) {
            $this->post(route('contact.send'), $this->contactPayload())->assertRedirect();
        }
        $this->post(route('contact.send'), $this->contactPayload())->assertStatus(429);
        $this->assertDatabaseCount('contacts', 0);
    }

    public function test_non_string_captcha_is_rejected_without_a_server_error(): void
    {
        $this->withSession(['captcha_code' => 'AB12'])
            ->post(route('contact.send'), [...$this->contactPayload(), 'captcha' => ['invalid']])
            ->assertRedirect()
            ->assertSessionHasErrors('captcha');
        $this->assertDatabaseCount('contacts', 0);
    }

    public function test_contact_message_length_is_bounded(): void
    {
        $this->withSession(['captcha_code' => 'AB12'])
            ->post(route('contact.send'), [...$this->contactPayload(), 'content' => str_repeat('x', 5001)])
            ->assertSessionHasErrors('content');
        $this->assertDatabaseCount('contacts', 0);
    }

    public function test_contact_honeypot_rejects_automated_submissions(): void
    {
        $this->withSession(['captcha_code' => 'AB12'])
            ->post(route('contact.send'), [...$this->contactPayload(), 'website' => 'https://spam.example'])
            ->assertSessionHasErrors('website');
        $this->assertDatabaseCount('contacts', 0);
    }

    public function test_untrusted_proxy_cannot_spoof_client_ip_or_https(): void
    {
        config(['security.trusted_proxies' => []]);
        Route::get('/security-test-ip', fn (Request $request) => response()->json([
            'ip' => $request->ip(),
            'secure' => $request->isSecure(),
        ]));

        $this->withServerVariables(['REMOTE_ADDR' => '203.0.113.10'])
            ->get('/security-test-ip', ['X-Forwarded-For' => '198.51.100.20', 'X-Forwarded-Proto' => 'https'])
            ->assertOk()->assertJson(['ip' => '203.0.113.10', 'secure' => false]);
    }

    public function test_private_networks_are_not_implicitly_allowed_when_production_policy_is_enabled(): void
    {
        config(['console.allow_private_networks' => false]);
        $this->withServerVariables(['REMOTE_ADDR' => '192.168.1.20'])
            ->get(route('console.login'))->assertNotFound();
    }

    public function test_explicitly_trusted_tunnel_proxy_supplies_https_and_visitor_ip(): void
    {
        config(['security.trusted_proxies' => ['127.0.0.1']]);
        Route::get('/security-test-trusted-ip', fn (Request $request) => response()->json([
            'ip' => $request->ip(),
            'secure' => $request->isSecure(),
        ]));

        $this->withServerVariables(['REMOTE_ADDR' => '127.0.0.1'])
            ->get('/security-test-trusted-ip', ['X-Forwarded-For' => '198.51.100.20', 'X-Forwarded-Proto' => 'https'])
            ->assertOk()->assertJson(['ip' => '198.51.100.20', 'secure' => true]);
    }

    public function test_seeding_does_not_reset_an_existing_admin_password(): void
    {
        $user = User::factory()->create(['email' => 'console@taigreat.com.tw', 'password' => 'Unchanged!Secure2026']);
        $this->seed(DatabaseSeeder::class);
        $this->assertTrue(Hash::check('Unchanged!Secure2026', $user->fresh()->password));
        $this->assertDatabaseCount('users', 1);
    }

    public function test_password_command_changes_only_the_requested_account_after_confirmation(): void
    {
        $user = User::factory()->create(['email' => 'admin@example.com']);
        $this->artisan('console:password', ['email' => $user->email])
            ->expectsQuestion('請輸入新密碼（至少 12 字元，含大小寫、數字與符號）', 'New!SecurePassword2026')
            ->expectsQuestion('請再次輸入新密碼', 'New!SecurePassword2026')
            ->assertExitCode(0);
        $this->assertTrue(Hash::check('New!SecurePassword2026', $user->fresh()->password));
    }

    public function test_password_command_rejects_mismatched_confirmation_without_changing_password(): void
    {
        $user = User::factory()->create(['email' => 'admin@example.com']);
        $before = $user->password;
        $this->artisan('console:password', ['email' => $user->email])
            ->expectsQuestion('請輸入新密碼（至少 12 字元，含大小寫、數字與符號）', 'New!SecurePassword2026')
            ->expectsQuestion('請再次輸入新密碼', 'Mismatch!Password2026')
            ->assertExitCode(1);
        $this->assertSame($before, $user->fresh()->password);
    }

    private function contactPayload(): array
    {
        return [
            'name' => '測試訪客', 'email' => 'visitor@example.com',
            'subject' => '詢問產品', 'content' => '請與我聯絡。',
            'captcha' => 'AB12', 'agree' => '1',
        ];
    }
}
