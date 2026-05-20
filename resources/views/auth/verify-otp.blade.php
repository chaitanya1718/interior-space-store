@extends('layouts.store')

@section('title', 'Verify OTP | Satya Interiors')

@section('content')
<main class="page auth-page">
    <section class="form-panel">
        <p class="eyebrow">Email verification</p>
        <h1>Enter OTP</h1>
        @if(session('status'))<p class="notice">{{ session('status') }}</p>@endif
        <p>We sent the OTP to {{ $email }}.</p>
        <form method="POST" action="{{ route('register.otp.verify') }}" class="stack-form" data-disable-on-submit>
            @csrf
            <label>OTP <input name="otp" inputmode="numeric" pattern="[0-9]{6}" maxlength="6" required autofocus></label>
            @if($errors->any())<p class="form-error">{{ $errors->first() }}</p>@endif
            <button class="button" type="submit" data-loading-text="Verifying...">Verify and create account</button>
        </form>
    </section>
</main>
@endsection
