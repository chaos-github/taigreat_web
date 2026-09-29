<?php

namespace Tests\Feature;

use App\Http\Middleware\EnsureConsoleIsInternal;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/** 後台內網限制：外網 404、內網可進、不可用 X-Forwarded-For 繞過。 */
class ConsoleInternalAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_console_login_is_hidden_from_public_networks(): void
    {
        $this->get('/console/login', ['REMOTE_ADDR' => '203.0.113.10'])
            ->assertNotFound();
    }

    public function test_console_dashboard_is_hidden_from_public_networks(): void
    {
        $this->get('/console', ['REMOTE_ADDR' => '203.0.113.10'])
            ->assertNotFound();
    }

    public function test_console_login_is_available_from_private_networks(): void
    {
        $this->get('/console/login', ['REMOTE_ADDR' => '192.168.10.20'])
            ->assertOk();
    }

    public function test_configured_public_ip_can_open_console(): void
    {
        config(['console.allowed_cidrs' => ['203.0.113.10']]);

        $this->get('/console/login', ['REMOTE_ADDR' => '203.0.113.10'])
            ->assertOk();
    }

    public function test_forwarded_private_ip_header_does_not_bypass_restriction(): void
    {
        $this->withHeader('X-Forwarded-For', '192.168.1.10')
            ->get('/console/login', ['REMOTE_ADDR' => '203.0.113.10'])
            ->assertNotFound();
    }

    public function test_cloudflare_tunnel_cannot_open_console(): void
    {
        $this->withHeaders([
            'CF-Ray' => '0123456789abcdef-TPE',
            'CF-Connecting-IP' => '203.0.113.50',
        ])->get('/console/login', ['REMOTE_ADDR' => '127.0.0.1'])
            ->assertNotFound();
    }

    public function test_cloudflare_tunnel_can_still_open_the_public_site(): void
    {
        $this->withHeaders([
            'CF-Ray' => '0123456789abcdef-TPE',
            'CF-Connecting-IP' => '203.0.113.50',
        ])->get('/', ['REMOTE_ADDR' => '127.0.0.1'])
            ->assertOk();
    }

    public function test_public_network_with_correct_uid_can_open_console_login(): void
    {
        $this->get('/console/login?uid='.EnsureConsoleIsInternal::ACCESS_UID, [
            'REMOTE_ADDR' => '203.0.113.10',
        ])->assertOk();
    }

    public function test_public_network_with_wrong_uid_is_still_hidden(): void
    {
        $this->get('/console/login?uid=wrong-uid', ['REMOTE_ADDR' => '203.0.113.10'])
            ->assertNotFound();
    }

    public function test_cloudflare_tunnel_with_correct_uid_can_open_console_login(): void
    {
        $this->withHeaders([
            'CF-Ray' => '0123456789abcdef-TPE',
            'CF-Connecting-IP' => '203.0.113.50',
        ])->get('/console/login?uid='.EnsureConsoleIsInternal::ACCESS_UID, [
            'REMOTE_ADDR' => '127.0.0.1',
        ])->assertOk();
    }

    public function test_console_uid_cookie_keeps_access_after_query_string(): void
    {
        $this->withUnencryptedCookie('console_uid', EnsureConsoleIsInternal::ACCESS_UID)
            ->get('/console/login', ['REMOTE_ADDR' => '203.0.113.10'])
            ->assertOk();
    }
}
