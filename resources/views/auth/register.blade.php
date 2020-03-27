@extends('layouts.app')

@section('content')
    <div class="auth-form_wrap">
        <a href="{{route('login')}}" class="auth-form_link">логин</a>
        <form class="auth-form" method="POST" action="{{ route('register') }}" novalidate>
            @csrf
            <div class="auth-form_title">Регистрация</div>
            <div class="auth-form_inputs">
                <label class="auth-form_label">Логин</label>
                <div class="auth-form_div">
                    @error('login') <label class="error-msg">{{ $message }}</label>@enderror
                    <input type="text" class="form_input @error('login') invalid @enderror"
                           value="{{ old('login') }}"
                           name="login">
                </div>
                <label class="auth-form_label">Пароль</label>
                <div class="auth-form_div">
                    @error('password')<label class="error-msg">{{ $message }}</label>@enderror
                    <input id="password" type="password" required autocomplete="new-password"
                           class="form_input @error('password') invalid @enderror"
                           value="{{ old('password') }}"
                           name="password">
                </div>
                <label class="auth-form_label">Повторите пароль</label>
                <div class="auth-form_div">
                    <input id="password-confirm" type="password" class="form_input"
                           name="password_confirmation"
                           required autocomplete="new-password">
                </div>
            </div>
            <button type="submit" for="submit" id="container" class="button-wrapp">
                <a  class="button">Зарегистрироваться</a>
            </button>
        </form>
    </div>
@endsection
