@extends('layouts.email')

@section('content')
    <h2>Your OTP Code</h2>
    <p>Dear {{ $name }},</p>
    <p>Thank you for using Appeto. Below is your One-Time Password (OTP) for verification:</p>
    <h3 style="font-weight: bold; font-size: 24px;">{{ $otp }}</h3>
    <p>This OTP is valid for 10 minutes. Please do not share it with anyone.</p>
    <p>If you did not request this, please ignore this email.</p>
@endsection
