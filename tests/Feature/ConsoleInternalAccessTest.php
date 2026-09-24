<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

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
}
