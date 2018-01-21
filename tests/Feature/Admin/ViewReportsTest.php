<?php

namespace Tests\Feature\Admin;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Permission;
use App\User;

class ViewReportsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_view_reports()
    {
        Permission::create(['name' => 'view_dashboard']);
        $user = factory(User::class)->create();
        $user->givePermissionTo('view_dashboard');

        $response = $this->withoutExceptionHandling()->actingAs($user)->get('/admin/reports');

        $response->assertStatus(200);
        $response->assertViewHas('reports');
    }

    /** @test */
    public function can_run_report()
    {
        Permission::create(['name' => 'view_dashboard']);
        $user = factory(User::class)->create();
        $user->givePermissionTo('view_dashboard');

        $response = $this->withoutExceptionHandling()->actingAs($user)
            ->post('/admin/reports/accommodation/run');

        $response->assertStatus(200);
        $response->assertJsonStructure(['data' => ['name', 'html', 'download']]);
    }
}
