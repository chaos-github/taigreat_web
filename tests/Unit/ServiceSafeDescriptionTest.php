<?php

namespace Tests\Unit;

use App\Models\Service;
use Tests\TestCase;

class ServiceSafeDescriptionTest extends TestCase
{
    public function test_script_tags_are_escaped(): void
    {
        $service = new Service([
            'description' => '<script>alert(1)</script>hello<br>world',
        ]);

        $html = (string) $service->safeDescription();

        $this->assertStringNotContainsString('<script>', $html);
        $this->assertStringContainsString('&lt;script&gt;alert(1)&lt;/script&gt;', $html);
        $this->assertStringContainsString("hello<br>\nworld", $html);
    }

    public function test_legacy_double_breaks_become_paragraph_spacing(): void
    {
        $service = new Service([
            'description' => "第一段<br><br>第二段",
        ]);

        $this->assertSame("第一段<br>\n<br>\n第二段", (string) $service->safeDescription());
    }
}
