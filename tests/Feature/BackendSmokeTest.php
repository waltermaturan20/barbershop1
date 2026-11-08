<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BackendSmokeTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_login_and_pages_render(): void
    {
        $this->seed();

        $this->post('/login', ['username' => 'admin', 'password' => 'password'])
            ->assertRedirect(route('admin.dashboard'));

        $this->get('/admin')->assertOk()->assertSee('Total Appointments');
        $this->get('/admin/service-categories')->assertOk()->assertSee('Haircuts');
        $this->get('/admin/services')->assertOk()->assertSee('Classic Haircut');
        $this->get('/admin/clients')->assertOk()->assertSee('Alex Santos');
        $this->get('/admin/barbers')->assertOk()->assertSee('Marco Reyes');
        $this->get('/admin/schedule')->assertOk()->assertSee('Appointments Schedule');
    }

    public function test_guest_cannot_access_admin(): void
    {
        $this->get('/admin')->assertRedirect(route('login'));
    }

    public function test_wrong_password_rejected(): void
    {
        $this->seed();
        $this->post('/login', ['username' => 'admin', 'password' => 'nope'])
            ->assertSessionHasErrors('username');
    }

    public function test_crud_service_category(): void
    {
        $this->seed();
        $this->post('/login', ['username' => 'admin', 'password' => 'password']);

        $this->post('/admin/service-categories', ['name' => 'New Cat'])
            ->assertRedirect(route('admin.service-categories'));

        $this->assertDatabaseHas('service_categories', ['name' => 'New Cat']);

        $id = \App\Models\ServiceCategory::where('name', 'New Cat')->value('id');
        $this->put("/admin/service-categories/$id", ['name' => 'Renamed Cat'])
            ->assertRedirect(route('admin.service-categories'));
        $this->assertDatabaseHas('service_categories', ['id' => $id, 'name' => 'Renamed Cat']);

        $this->delete("/admin/service-categories/$id")
            ->assertRedirect(route('admin.service-categories'));
        $this->assertDatabaseMissing('service_categories', ['id' => $id]);
    }

    public function test_crud_appointment(): void
    {
        $this->seed();
        $this->post('/login', ['username' => 'admin', 'password' => 'password']);

        $this->post('/admin/schedule', [
            'client_id' => \App\Models\Client::first()->id,
            'barber_id' => \App\Models\Barber::first()->id,
            'service_id' => \App\Models\Service::first()->id,
            'appointment_date' => '2026-12-01 00:00:00',
            'appointment_time' => '11:00',
            'status' => 'pending',
        ])->assertRedirect(route('admin.schedule'));

        $this->assertDatabaseHas('appointments', [
            'appointment_date' => '2026-12-01 00:00:00',
            'appointment_time' => '11:00',
            'status' => 'pending',
        ]);
    }
}