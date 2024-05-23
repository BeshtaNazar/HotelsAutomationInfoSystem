@extends('components.layout')
@section('title', 'Profile | Hotels Automation')
@section('css')
    <link rel="stylesheet" href="{{ asset('css/pages/account/profile.css') }}">
@endsection
@section('content')
    <div class="profile-wrapper">
        <div class="container">
            <div class="row">
                <div class="col nav-col">
                    <ul>
                        <li><a href={{ route('account.reservations') }}>Reservations</a></li>
                        <li><a href={{ route('hotel.manage') }}>Manage your hotels</a></li>
                        @if ($isAdmin)
                            <li><a href={{ route('hotel.requests') }}>Manage hotels requests</a></li>
                        @endif
                        <li><a href={{ route('logout') }}>Logout</a></li>
                    </ul>
                </div>
                <div class="col">
                    <form action="/account/update" method="POST" autocomplete="off" id="updateInfoForm">
                        @csrf
                        @method('PATCH')
                        <div class="section-title">
                            <h2>Update your info</h2>
                            <hr>
                        </div>
                        <div class="form-row">
                            <span class="current-data">Your current first name - {{ $user->first_name }}</span>
                            <label for="firstName">First Name</label>
                            <input type="text" id="firstName" maxlength="100" name="firstName"
                                value="{{ $user->first_name }}">
                            <span id="firstNameError" class="error-message"></span>
                        </div>
                        <div class="form-row">
                            <span class="current-data">Your current last name - {{ $user->last_name }}</span>
                            <label for="lastName">Last Name</label>
                            <input type="text" id="lastName" maxlength="100" name="lastName"
                                value="{{ $user->last_name }}">
                            <span id="lastNameError" class="error-message"></span>
                        </div>
                        <div class="birthday-form-row">
                            <div class="form-row-title">
                                <h2>Birthday</h2>
                            </div>
                            <span class="current-data">Your current birthday -
                                {{ date('F j, Y', strtotime($user->birthday)) }}</span>
                            <div class="row">
                                <div class="form-row">
                                    <label for="birthday">Day</label>
                                    <input type="number" min="0" max="31" id="birthday" name="birthday"
                                        value="{{ date('j', strtotime($user->birthday)) }}">
                                    <span id="birthdayError" class="error-message"></span>
                                </div>
                                <div class="form-row">
                                    <label for="birthMonth">Month</label>
                                    <select class="custom-select" name="birthMonth">
                                        @for ($i = 1; $i <= 12; $i++)
                                            <option value="{{ $i }}"
                                                @if (date('n', strtotime($user->birthday)) == $i) selected @endif>
                                                {{ date('F', mktime(0, 0, 0, $i, 1)) }}</option>
                                        @endfor
                                    </select>
                                </div>
                                <div class="form-row">
                                    <label for="birthYear">Year</label>
                                    <input type="number" min="0" max="9999" id="birthYear" name="birthYear"
                                        value="{{ date('Y', strtotime($user->birthday)) }}">
                                    <span id="birthYearError" class="error-message"></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <span class="current-data">Your current phone - {{ $user->phone }}</span>
                            <label for="phone">Mobile Phone</label>
                            <input type="text" id="phone" maxlength="20" name="phone" value="{{ $user->phone }}">
                            <span id="phoneError" class="error-message"></span>
                        </div>
                        <div class="form-row">
                            <span class="current-data">Your current email - {{ $user->email }}</span>
                            <label for="email">Email</label>
                            <input type="text" id="email" maxlength="100" name="email"
                                value="{{ $user->email }}">
                            <span id="emailError" class="error-message"></span>
                        </div>
                        <div class="form-row">
                            <label for="country">Country</label>
                            <span class="current-data">Your current country - {{ $user->country }}</span>
                            <select class="custom-select register-page-select" name="country">
                                <option value="" selected="selected">Select Country</option>
                                @foreach ($countries as $country)
                                    <option value="{{ $country }}" @if ($user->country == $country) selected @endif>
                                        {{ $country }}</option>
                                @endforeach
                            </select>
                            <span id="countryError" class="error-message"></span>
                        </div>
                        <div class="form-row">
                            <span id="formError" class="error-message"></span>
                        </div>
                        <div class="form-row" id="update-info-submit">
                            <button class="submit-button" type="submit">Update</button>
                        </div>
                    </form>
                    <form action="/account/change-password" method="POST" id="changePasswordForm">
                        @csrf
                        @method('PATCH')
                        <div class="section-title">
                            <h2>Change password</h2>
                            <hr>
                        </div>
                        @if (!empty(session('wrong_password_error')))
                            <div role="alert" class="alert-message failure-message">
                                {{ session('wrong_password_error') }}
                            </div>
                        @endif
                        @if (!empty(session('password_change_success')))
                            <div role="alert" class="alert-message success-message">
                                {{ session('password_change_success') }}
                            </div>
                        @endif
                        <div class="form-row change-password-row">
                            <div class="row">
                                <label for="currentPassword">Current password</label>
                                <div class="password-input-container">
                                    <input type="password" id="currentPassword" maxlength="100" name="currentPassword">
                                    <a class="toggle-password-visibility-icon">
                                        <svg viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" fill="none">
                                            <path fill="#000000" fill-rule="evenodd"
                                                d="M3.415 10.242c-.067-.086-.13-.167-.186-.242a16.806 16.806 0 011.803-2.025C6.429 6.648 8.187 5.5 10 5.5c1.813 0 3.57 1.148 4.968 2.475A16.816 16.816 0 0116.771 10a16.9 16.9 0 01-1.803 2.025C13.57 13.352 11.813 14.5 10 14.5c-1.813 0-3.57-1.148-4.968-2.475a16.799 16.799 0 01-1.617-1.783zm15.423-.788L18 10l.838.546-.002.003-.003.004-.01.016-.037.054a17.123 17.123 0 01-.628.854 18.805 18.805 0 01-1.812 1.998C14.848 14.898 12.606 16.5 10 16.5s-4.848-1.602-6.346-3.025a18.806 18.806 0 01-2.44-2.852 6.01 6.01 0 01-.037-.054l-.01-.016-.003-.004-.001-.002c0-.001-.001-.001.837-.547l-.838-.546.002-.003.003-.004.01-.016a6.84 6.84 0 01.17-.245 18.804 18.804 0 012.308-2.66C5.151 5.1 7.394 3.499 10 3.499s4.848 1.602 6.346 3.025a18.803 18.803 0 012.44 2.852l.037.054.01.016.003.004.001.002zM18 10l.838-.546.355.546-.355.546L18 10zM1.162 9.454L2 10l-.838.546L.807 10l.355-.546zM9 10a1 1 0 112 0 1 1 0 01-2 0zm1-3a3 3 0 100 6 3 3 0 000-6z" />
                                        </svg>
                                    </a>
                                </div>
                            </div>
                            <div class="row password-req-row">
                                <div class="col">
                                    <label for="newPassword">New password</label>
                                    <div class="password-input-container">
                                        <input type="password" id="newPassword" maxlength="100" name="newPassword">
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
                        </div>
                        <div class="form-row" id="change-password-submit">
                            <button class="submit-button" type="submit">Change</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ asset('js/profile/validateUpdateInputs.js') }}"></script>
    <script src="{{ asset('js/profile/validateNewPassword.js') }}"></script>
@endsection
