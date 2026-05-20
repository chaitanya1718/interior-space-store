@extends('layouts.store')

@section('title', 'Admin Login | Satya Interiors')

@section('content')
<main class="page auth-page">
    <section class="form-panel">
        <p class="eyebrow">Admin access</p>
        <h1>Admin login</h1>
        <form method="POST" action="{{ route('admin.login.submit') }}" class="stack-form" data-disable-on-submit>
            @csrf
            <label>Email <input name="email" type="email" value="{{ old('email') }}" required autofocus></label>
            <label>Password <input name="password" type="password" required></label>
            <label class="check"><input name="remember" type="checkbox"> Remember me</label>
            @error('email')<p class="form-error">{{ $message }}</p>@enderror
            <button class="button" type="submit" data-loading-text="Logging in...">Login to admin</button>
        </form>
    </section>
</main>
@endsection
