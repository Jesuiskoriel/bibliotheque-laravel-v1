<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminUserBanTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_ban_and_unban_a_user(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $user = User::factory()->create(['role' => 'user', 'is_blocked' => false, 'blocked_at' => null]);

        $this->actingAs($admin)
            ->patch(route('admin.users.toggle-block', $user))
            ->assertRedirect();

        $user->refresh();
        $this->assertTrue($user->is_blocked);
        $this->assertNotNull($user->blocked_at);

        $this->actingAs($admin)
            ->patch(route('admin.users.toggle-block', $user))
            ->assertRedirect();

        $user->refresh();
        $this->assertFalse($user->is_blocked);
        $this->assertNull($user->blocked_at);
    }

    public function test_blocked_user_is_kicked_out_from_user_area(): void
    {
        $blockedUser = User::factory()->create([
            'role' => 'user',
            'is_blocked' => true,
            'blocked_at' => now(),
        ]);

        $this->actingAs($blockedUser)
            ->get(route('user.dashboard'))
            ->assertRedirect(route('login'))
            ->assertSessionHasErrors('email');

        $this->assertGuest();
    }
}
