<?php

namespace Tests\Unit\Admin;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Admin\Reports\Accommodation;
use App\Profile;

class ReportTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_generate_html()
    {
        $profiles = factory(Profile::class)->times(5)->create(['accommodation' => 'Hello world']);

        $accommodation = new Accommodation;

        $data = $accommodation->generateHtml();

        $this->assertNotNull($data);
    }
}
