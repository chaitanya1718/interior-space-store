@extends('layouts.store')

@section('title', 'Register | Satya Interiors')

@section('content')
<main class="page auth-page">
    <section class="form-panel">
        <p class="eyebrow">Create account</p>
        <h1>Register</h1>
        <form method="POST" action="{{ route('register') }}" class="stack-form" data-disable-on-submit>
            @csrf
            <label>Name <input name="name" value="{{ old('name') }}" required autofocus></label>
            <label>Email <input name="email" type="email" value="{{ old('email') }}" required></label>
            <label>Password <input name="password" type="password" required></label>
            <label>Confirm password <input name="password_confirmation" type="password" required></label>
            @if($errors->any())<p class="form-error">{{ $errors->first() }}</p>@endif
            <button class="button" type="submit" data-loading-text="Sending OTP...">Create account</button>
        </form>
        <p>Already registered? <a class="text-link" href="{{ route('login') }}">Login</a></p>
    </section>
</main>
@endsection
