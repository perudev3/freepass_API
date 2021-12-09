@extends('layouts.app_front')

@section('content')

    <section class="account-section">
        <div class="container">
            <div class="padding-top padding-bottom">
                <div class="account-area">
                    <div class="section-header-3">
                        <h2 class="title">Bienvenido a FreePass</h2>
                    </div>
                    <form class="account-form" method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="text" class="@error('email') is-invalid @enderror" id="email" name="email" required value="{{ old('email') }}">
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="password">Contraseña</label>
                            <input type="password" class="@error('password') is-invalid @enderror" id="password" name="password" required autocomplete="current-password">
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group checkgroup">
                            @if (Route::has('password.request'))
                                <a class="forget-pass" href="{{ route('password.request') }}">
                                    {{ __('¿Olvidaste tu contraseña?') }}
                                </a>
                            @endif
                        </div>
                        <div class="form-group text-center">
                            <button type="submit" style="background: #0b0b68a1;border-color: #0b0b68a1;">
                                {{ __('Login') }}
                            </button>
                        </div>
                    </form>
                    <div class="option">
                        ¿No tienes una cuenta? <a href="{{ url('/register') }}">Registrate</a>.
                    </div>
                    <div class="or"><span>ó</span></div>
                    <ul class="social-icons">
                        <li>
                            <a href="{{ url('/auth/facebook') }}">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('/auth/google') }}">
                                <i class="fab fa-google"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

@endsection
