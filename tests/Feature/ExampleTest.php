<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     */
    //Basic Authentication
    public function test_authenticated_user_can_access_protected_route()
    {
        $user = User::factory()->create([
            'username' => 'testuser_' . rand(1000, 9999),
            'role'=>'admin',
        ]);
        $this->actingAs($user);
        $response = $this->get('/home');

        $response->assertStatus(200);
    }
}
