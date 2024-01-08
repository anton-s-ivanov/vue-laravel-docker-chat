<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class ChatMessageControllerTest extends TestCase
{
    public function test_only_auth_users_can_get_user_chats_access()
    {
        $headers = [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json;charset=utf-8'
        ];

        $response = $this->get('/api/user-chats', $headers);
        $response->assertStatus(401);

        $user = User::all()->random();

        $response = $this->actingAs($user)->get('/api/user-chats', $headers);
        $response->assertSuccessful(); 
    }

    public function test_get_chats_method_returns_correct_data()
    {
        $headers = [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json;charset=utf-8'
        ];

        $user = User::all()->random();
        Auth::login($user);

        $response = $this->actingAs($user)->get('/api/user-chats', $headers);

        $responseArr = $response->json();
        $responseArrIds = [];

        foreach($responseArr as $arr) {
            $responseArrIds[] = $arr['id'];
        }

        $this->assertEquals(User::all()->count() - 1, count($response->decodeResponseJson()));
        $this->assertEquals(false, in_array(Auth::id(), $responseArrIds));

        $this->assertEquals(true, isset($responseArr[0]['id']));
        $this->assertEquals(true, isset($responseArr[0]['name']));
        
        $this->assertEquals(false, isset($responseArr[0]['email']));
        $this->assertEquals(false, isset($responseArr[0]['email_verified_at']));
        $this->assertEquals(false, isset($responseArr[0]['remember_token']));
        $this->assertEquals(false, isset($responseArr[0]['created_at']));
        $this->assertEquals(false, isset($responseArr[0]['updated_at']));
    }
}
