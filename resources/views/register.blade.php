@extends('components.layout')
@section('title', 'Register | Hotels Automation')
@section('css')
    <link rel="stylesheet" href="{{ asset('css/pages/register.css') }}">
@endsection
@section('content')
    <div class="register-wrapper">
        <div class="container">
            <form id="registerForm" action="/register" method="POST" autocomplete="off">
                @csrf
                <div class="page-title">
                    <h2>Create account</h2>
                    <hr>
                </div>
                <div class="form-row">
                    <label for="firstName">First Name</label>
                    <input type="text" id="firstName" maxlength="100" name="firstName">
                    <span id="firstNameError" class="error-message"></span>
                </div>
                <div class="form-row">
                    <label for="lastName">Last Name</label>
                    <input type="text" id="lastName" maxlength="100" name="lastName">
                    <span id="lastNameError" class="error-message"></span>
                </div>
                <div class="birthday-form-row">
                    <div class="form-row-title">
                        <h2>Birthday</h2>
                    </div>
                    <div class="row">
                        <div class="form-row">
                            <label for="birthday">Day</label>
                            <input type="number" min="0" max="31" id="birthday" name="birthday">
                            <span id="birthdayError" class="error-message"></span>
                        </div>
                        <div class="form-row">
                            <label for="birthMonth">Month</label>
                            <select class="custom-select" name="birthMonth">
                                <option value="1">January</option>
                                <option value="2">February</option>
                                <option value="3">March</option>
                                <option value="4">April</option>
                                <option value="5">May</option>
                                <option value="6">June</option>
                                <option value="7">July</option>
                                <option value="8">August</option>
                                <option value="9">September</option>
                                <option value="10">October</option>
                                <option value="11">November</option>
                                <option value="12">December</option>
                            </select>
                        </div>
                        <div class="form-row">
                            <label for="birthYear">Year</label>
                            <input type="number" min="0" max="9999" id="birthYear" name="birthYear">
                            <span id="birthYearError" class="error-message"></span>
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <label for="phone">Mobile Phone</label>
                    <input type="text" id="phone" maxlength="20" name="phone">
                    <span id="phoneError" class="error-message"></span>
                </div>
                <div class="form-row">
                    <label for="email">Email</label>
                    <input type="text" id="email" maxlength="100" name="email">
                    <span id="emailError" class="error-message"></span>
                </div>
                <div class="form-row">
                    <label for="country">Country</label>
                    <select class="custom-select register-page-select" name="country">
                        @foreach ($countries as $country)
                            <option value="{{ $country }}">{{ $country }}</option>
                        @endforeach
                    </select>
                    <span id="countryError" class="error-message"></span>
                </div>
                <div class="form-row password-req-row">
                    <div class="col">
                        <label for="password">Password</label>
                        <div class="password-input-container">
                            <input type="password" id="password" maxlength="100" name="password">
                            <a class="toggle-password-visibility-icon">
                                <svg viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" fill="none">
                                    <path fill="#000000" fill-rule="evenodd"
                                        d="M3.415 10.242c-.067-.086-.13-.167-.186-.242a16.806 16.806 0 011.803-2.025C6.429 6.648 8.187 5.5 10 5.5c1.813 0 3.57 1.148 4.968 2.475A16.816 16.816 0 0116.771 10a16.9 16.9 0 01-1.803 2.025C13.57 13.352 11.813 14.5 10 14.5c-1.813 0-3.57-1.148-4.968-2.475a16.799 16.799 0 01-1.617-1.783zm15.423-.788L18 10l.838.546-.002.003-.003.004-.01.016-.037.054a17.123 17.123 0 01-.628.854 18.805 18.805 0 01-1.812 1.998C14.848 14.898 12.606 16.5 10 16.5s-4.848-1.602-6.346-3.025a18.806 18.806 0 01-2.44-2.852 6.01 6.01 0 01-.037-.054l-.01-.016-.003-.004-.001-.002c0-.001-.001-.001.837-.547l-.838-.546.002-.003.003-.004.01-.016a6.84 6.84 0 01.17-.245 18.804 18.804 0 012.308-2.66C5.151 5.1 7.394 3.499 10 3.499s4.848 1.602 6.346 3.025a18.803 18.803 0 012.44 2.852l.037.054.01.016.003.004.001.002zM18 10l.838-.546.355.546-.355.546L18 10zM1.162 9.454L2 10l-.838.546L.807 10l.355-.546zM9 10a1 1 0 112 0 1 1 0 01-2 0zm1-3a3 3 0 100 6 3 3 0 000-6z" />
                                </svg>
                            </a>
                        </div>
                        <span id="passwordError" class="error-message"></span>
                        <div class="password-req">
                            <h2>YOUR PASSWORD MUST HAVE:</h2>
                            <ul>
                                <li>At least 8 characters</li>
                                <li>At least one lower case letter.</li>
                                <li>At least one upper case letter.</li>
                                <li>At least one number and special character.</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="form-row register-submit-button">
                    <button class="submit-button" type="submit">Create</button>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ asset('js/togglePassword.js') }}"></script>
    <script src="{{ asset('js/register/validateInputs.js') }}"></script>
@endsection
