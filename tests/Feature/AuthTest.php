<?php

namespace Tests\Feature;

use App\Mail\Auth\OtpEmail;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    protected string $baseUrl = '/api/v1/auth/';

    public function testSendOtp()
    {
        Mail::fake();

        $response = $this->postJson($this->baseUrl.'send-otp', [
            'email' => 'test@example.com',
        ]);

        $response->assertStatus(200)
            ->assertJson(['message' => 'user has been created now verify your email']);

        Mail::assertSent(OtpEmail::class);
    }

    public function testVerifyOtpSuccessful()
    {
        $user = User::create(['email' => 'test@example.com']);
        $otp = random_int(10000, 99999);
        Cache::put($user->email, $otp, 3);

        $response = $this->postJson($this->baseUrl.'verify-otp', [
            'email' => 'test@example.com',
            'password' => 'newPassword',
            'password_confirmation' => 'newPassword',
            'otp' => $otp,
            'name' => 'Test User',
        ]);

        $response->assertStatus(200)
            ->assertJson(['message' => 'User Created Successfully']);
    }

    public function testLoginSuccessful()
    {
        $user = User::create(['email' => 'test@example.com', 'password' => Hash::make('password')]);

        $response = $this->postJson($this->baseUrl.'login', [
            'email' => 'test@example.com',
            'password' => 'password',
        ]);

        $response->assertStatus(200)
            ->assertJson(['message' => 'welcome']);
    }

    public function testForgetPasswordSendOtp()
    {
        Mail::fake();
        User::create(['email' => 'test@example.com', 'password' => Hash::make('password')]);

        $response = $this->postJson($this->baseUrl.'forget-password/send-otp', [
            'email' => 'test@example.com',
        ]);

        $response->assertStatus(200)
            ->assertJson(['message' => 'Forget Password Otp Code Has Been Sent']);

        Mail::assertSent(OtpEmail::class);
    }

    public function testForgetPasswordVerifyOtpSuccessful()
    {
        $user = User::create(['email' => 'test@example.com', 'password' => bcrypt('password')]);
        $otp = random_int(10000, 99999);
        Cache::put($user->email, $otp, 3);

        $response = $this->postJson($this->baseUrl.'forget-password/verify-otp', [
            'email' => 'test@example.com',
            'otp' => $otp,
            'password' => 'newPassword',
            'password_confirmation' => 'newPassword',
        ]);

        $response->assertStatus(200)
            ->assertJson(['message' => 'Password Has Been Changed Successfully']);
    }
}
