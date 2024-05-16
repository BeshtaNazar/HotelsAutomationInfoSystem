@extends('components.layout')
@section('title', 'Login | Hotels Automation')
@section('css')
    <link rel="stylesheet" href="{{ asset('css/pages/login.css') }}">
@endsection
@section('content')
    <div class="login-wrapper">
        <div class="container">
            @if (!empty(session('success')))
                <div role="alert" class="alert-message success-message">
                    {{ session('success') }}
                </div>
            @endif
            @if (!empty(session('failure')))
                <div role="alert" class="alert-message failure-message">
                    {{ session('failure') }}
                </div>
            @endif
            <div class="row">
                <div class="col">
                    <form action={{ url('login') }} method="post" autocomplete="off">
                        @csrf
                        <div class="page-title">
                            <h2>Log in</h2>
                            <hr>
                        </div>
                        <div class="form-row">
                            <label for="email">Email</label>
                            <input type="email" name="email">
                        </div>
                        <div class="form-row">
                            <label for="password">Password</label>
                            <div class="password-input-container">
                                <input type="password" id="password" name="password">
                                <a class="toggle-password-visibility-icon">
                                    <svg viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" fill="none">
                                        <path fill="#000000" fill-rule="evenodd"
                                            d="M3.415 10.242c-.067-.086-.13-.167-.186-.242a16.806 16.806 0 011.803-2.025C6.429 6.648 8.187 5.5 10 5.5c1.813 0 3.57 1.148 4.968 2.475A16.816 16.816 0 0116.771 10a16.9 16.9 0 01-1.803 2.025C13.57 13.352 11.813 14.5 10 14.5c-1.813 0-3.57-1.148-4.968-2.475a16.799 16.799 0 01-1.617-1.783zm15.423-.788L18 10l.838.546-.002.003-.003.004-.01.016-.037.054a17.123 17.123 0 01-.628.854 18.805 18.805 0 01-1.812 1.998C14.848 14.898 12.606 16.5 10 16.5s-4.848-1.602-6.346-3.025a18.806 18.806 0 01-2.44-2.852 6.01 6.01 0 01-.037-.054l-.01-.016-.003-.004-.001-.002c0-.001-.001-.001.837-.547l-.838-.546.002-.003.003-.004.01-.016a6.84 6.84 0 01.17-.245 18.804 18.804 0 012.308-2.66C5.151 5.1 7.394 3.499 10 3.499s4.848 1.602 6.346 3.025a18.803 18.803 0 012.44 2.852l.037.054.01.016.003.004.001.002zM18 10l.838-.546.355.546-.355.546L18 10zM1.162 9.454L2 10l-.838.546L.807 10l.355-.546zM9 10a1 1 0 112 0 1 1 0 01-2 0zm1-3a3 3 0 100 6 3 3 0 000-6z" />
                                    </svg>
                                </a>
                            </div>
                            <a class="forgot-password-link" href="password-restore">Forgot password?</a>

                        </div>
                        <div class="form-row checkbox-row">
                            <input type="checkbox" name="remember" id="remember">
                            <label for="remember">Remember me</label>
                        </div>
                        <div class="form-row">
                            <button class="submit-button" type="submit">Sign in</button>
                        </div>
                    </form>
                </div>
                <div class="col">
                    <div class="no-account">
                        <h2 class="no-account-title">Don't have an account?</h2>
                        <a href="/register" class="create-account-link">Create account</a>
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection
@section('script')
    <script src="{{ asset('js/togglePassword.js') }}"></script>
@endsection
