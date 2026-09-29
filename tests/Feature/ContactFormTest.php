<?php

namespace Tests\Feature;

use App\Models\Contact;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ContactFormTest extends TestCase
{
    use RefreshDatabase;

    public function test_contact_page_is_available(): void
    {
        $this->get(route('contact'))
            ->assertOk()
            ->assertSee('聯絡資訊', false);
    }

    public function test_contact_form_is_saved_to_the_database(): void
    {
        $this->withSession(['captcha_code' => 'AB12'])
            ->from(route('contact'))
            ->post(route('contact.send'), [
                'name' => '王小明',
                'company' => '測試公司',
                'tel' => '04-24220159',
                'email' => 'ming@example.com',
                'subject' => '詢問模板',
                'content' => "第一行\n第二行",
                'captcha' => 'AB12',
                'agree' => '1',
            ])
            ->assertRedirect(route('contact'))
            ->assertSessionHas('status');

        $this->assertDatabaseHas('contacts', [
            'name' => '王小明',
            'company' => '測試公司',
            'tel' => '04-24220159',
            'email' => 'ming@example.com',
            'subject' => '詢問模板',
            'content' => "第一行\n第二行",
        ]);
    }

    public function test_invalid_captcha_is_rejected(): void
    {
        $this->withSession(['captcha_code' => 'AB12'])
            ->from(route('contact'))
            ->post(route('contact.send'), [
                'name' => '王小明',
                'email' => 'ming@example.com',
                'subject' => '詢問模板',
                'content' => '內容',
                'captcha' => 'XXXX',
                'agree' => '1',
            ])
            ->assertRedirect(route('contact'))
            ->assertSessionHasErrors('captcha');

        $this->assertDatabaseCount('contacts', 0);
    }

    public function test_console_can_view_and_delete_a_contact(): void
    {
        $user = User::factory()->create();
        $contact = Contact::query()->create([
            'name' => '王小明',
            'company' => '測試公司',
            'tel' => '04-24220159',
            'email' => 'ming@example.com',
            'subject' => '詢問模板',
            'content' => '想了解產品',
        ]);

        $this->actingAs($user)
            ->get(route('console.contacts.index'))
            ->assertOk()
            ->assertSee('王小明', false)
            ->assertSee('詢問模板', false);

        $this->actingAs($user)
            ->get(route('console.contacts.show', $contact))
            ->assertOk()
            ->assertSee('想了解產品', false)
            ->assertSee('ming@example.com', false);

        $this->actingAs($user)
            ->delete(route('console.contacts.destroy', $contact))
            ->assertRedirect(route('console.contacts.index'));

        $this->assertDatabaseMissing('contacts', ['id' => $contact->id]);
    }
}
