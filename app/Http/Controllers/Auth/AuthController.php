<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ForgetPasswordVerifyOtp;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\SendOtpRequest;
use App\Http\Requests\Auth\VerifyOtpRequest;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Mail\Auth\OtpEmail;

class AuthController extends Controller
{
    public function sendOtp(SendOtpRequest $request): JsonResponse
    {
        $validated = $request->safe()->only(['email']);

        $user = User::create([
            'email' => $validated['email'],
        ]);
        $otp = random_int(10000, 99999);


        dispatch(function () use ($otp, $validated) {
            $this->processOtp($otp, $validated['email']);
        });

        return $this->success($user, 'user has been created now verify your email');
    }
    public function reSendOtp(Request $request): JsonResponse
    {

        $validated = $request->validate([
            'email' => ['required', 'email'],
        ]);

//        dd(Cache::get($validated['email']));
        $user = User::where('email', $validated['email'])->first();

        if($user){

            $otp = random_int(10000, 99999);


            dispatch(function () use ($otp, $validated) {
                $this->processOtp($otp, $validated['email']);
            });


            return $this->success($user, 'otp email has been sent again now verify your email');
        }else{

            return $this->error([], 'user not found', 404);
        }
    }

    public function verifyOtp(VerifyOtpRequest $request): JsonResponse
    {
        $validated = $request->safe()->only(['email','password', 'otp', 'name']);

        $user = User::where('email', $validated['email'])->first();
        if($user){

            $otp = Cache::get($validated['email']);

            if($otp && $otp == $validated['otp']){


                $user->update([
                    'password' => Hash::make($validated['password']),
                    'name' => $validated['name'],
                    'email_verified_at' => Carbon::now(),
                ]);
                $token = $user->createToken('access token')->plainTextToken;

                $user['token'] = $token;
                Cache::delete($validated['email']);
                return $this->success($user, 'User Created Successfully');
            }else{

                return $this->error([], 'Otp was not Valid');
            }
        }else{

            return $this->error([], 'user was not found', 404);
        }

    }

    public function login(LoginRequest $request): JsonResponse
    {

        $validated = $request->safe()->only(['email', 'password']);
        $user = User::where('email', $validated['email'])->first();

        if (!$user  or $user->email_verified_at == null){

            return $this->error([], 'verify your email first');
        }
        if (Auth::attempt($validated)){
            $user = $request->user();
            $token = $user->createToken('Auth Token')->plainTextToken;

            $user['token'] = $token;

            return $this->success($user, 'welcome');
        }else{
            return $this->error([], 'credentials was wrong');
        }
    }

    public function forgetPasswordSendOtp(Request $request): JsonResponse
    {


        $validated = $request->validate([
            'email' => ['required', 'email', 'max:255'],
        ]);



        $otp = random_int(10000, 99999);

        $user = User::where('email', $validated['email'])->first();

        if($user){


            dispatch(function () use ($otp, $validated) {
                $this->processOtp($otp, $validated['email']);
            });
            return $this->success([], 'Forget Password Otp Code Has Been Sent');
        }else{

            return $this->error( 'User Not Found', 404);
        }

    }
    public function forgetPasswordVerifyOtp(ForgetPasswordVerifyOtp $request): JsonResponse
    {

        $validated = $request->safe()->only(['email', 'otp', 'password']);

        $user = User::where('email', $validated['email'])->first();
        if($user){

            $otp = Cache::get($validated['email']);


            if($otp && $otp == $validated['otp']){

                $user->update([
                    'password' => Hash::make($validated['password']),
                ]);

                return $this->success([], 'Password Has Been Changed Successfully');
            }else{

                return $this->error([], 'Otp was not Valid');
            }
        }else{

            return $this->error([], 'user was not found', 404);
        }

    }


    private function processOtp($otp, $email): void
    {
//        $hashedOtp = Hash::make($otp);


        Cache::put($email, $otp, 120);

        $name = Str::before($email, '@');


        //Sending Email
        $emailService = new OtpEmail($name, $otp);
        $result = Mail::to($email)->send($emailService);

        if($result){

            Log::warning($result->toString());
        }

    }
}
