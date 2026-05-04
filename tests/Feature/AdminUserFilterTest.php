<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminUserFilterTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_filter_users_by_status(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $activeUser = User::factory()->create(['role' => 'user', 'name' => 'Alice Active', 'is_blocked' => false]);
        $bannedUser = User::factory()->create(['role' => 'user', 'name' => 'Bob Banned', 'is_blocked' => true]);

        $response = $this->actingAs($admin)->get(route('admin.users.index', ['status' => 'banned']));

        $response->assertOk();
        $response->assertSee($bannedUser->name);
        $response->assertDontSee($activeUser->name);
    }

    public function test_admin_can_search_users_by_name_or_email(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $target = User::factory()->create([
            'role' => 'user',
            'name' => 'Recherche Cible',
            'email' => 'cible@example.test',
        ]);
        $other = User::factory()->create([
            'role' => 'user',
            'name' => 'Autre Utilisateur',
            'email' => 'autre@example.test',
        ]);

        $response = $this->actingAs($admin)->get(route('admin.users.index', ['q' => 'cible']));

        $response->assertOk();
        $response->assertSee($target->name);
        $response->assertDontSee($other->name);
    }
}
