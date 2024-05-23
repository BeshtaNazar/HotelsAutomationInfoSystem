@extends('components.layout')
@section('title', 'Restore Password | Hotels Automation')
@section('css')
@endsection
@section('content')
    <div class="forgot-wrapper">
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
                    <form action={{ route('forgot.password.link') }} method="post" autocomplete="off">
                        @csrf
                        <div class="page-title">
                            <h2>Restore Password</h2>
                            <hr>
                        </div>
                        <div class="form-row">
                            <label for="email">Email</label>
                            <input type="text" name="email" value="{{ old('email') }}">
                            <span id="emailError" class="error-message">
                                @error('email')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>
                        <div class="form-row">
                            <button class="submit-button" type="submit">Send password reset link</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
@endsection
