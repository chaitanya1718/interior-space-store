@extends('layouts.store')

@section('title', 'Login | Satya Interiors')

@section('content')
<main class="page auth-page">
    <section class="form-panel">
        <p class="eyebrow">Welcome back</p>
        <h1>Login</h1>
        <form method="POST" action="{{ route('login') }}" class="stack-form" data-disable-on-submit>
            @csrf
            <label>Email <input name="email" type="email" value="{{ old('email') }}" required autofocus></label>
            <label>Password <input name="password" type="password" required></label>
            <label class="check"><input name="remember" type="checkbox"> Remember me</label>
            @error('email')<p class="form-error">{{ $message }}</p>@enderror
            <button class="button" type="submit" data-loading-text="Logging in...">Login</button>
        </form>
        <p>New here? <a class="text-link" href="{{ route('register') }}">Create an account</a></p>
    </section>
</main>
@endsection
