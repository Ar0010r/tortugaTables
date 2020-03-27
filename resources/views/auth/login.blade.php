@extends('layouts.app')

@section('content')
    <div class="auth-form_wrap container">
        <a  href="{{route('register')}}" class="auth-form_link">Регистрация</a>
        <form class="login-form auth-form" method="POST" action="/login">
            @csrf
            <div class="auth-form_title">Логин</div>
            <div class="login-form_inputs">
                <label class="auth-form_label">Логин</label>
                <div class="auth-form_div">

                    @error('login')
                    <label class="error-msg">{{ $message }}</label>
                    @enderror

                    <input type="text" class="form_input @error('login') invalid @enderror"
                           value="{{ old('login') }}"
                           name="login">
                </div>
                <label class="auth-form_label">Пароль</label>
                <div class="auth-form_div">
                    @error('password')
                    <label class="error-msg">{{ $message }}</label>
                    @enderror
                    <input type="password" class="form_input @error('password') invalid @enderror"
                           value="{{ old('password') }}"
                           name="password">
                </div>
            </div>
            <button type="submit" id="container" class="button-wrapp">
                <div class="button">Войти</div>
            </button>
        </form>
    </div>
@endsection
