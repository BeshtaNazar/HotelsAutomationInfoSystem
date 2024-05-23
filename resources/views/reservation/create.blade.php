@extends('components.layout')
@section('title', 'Make Reservation | Hotels Automation')
@section('css')
    <link rel="stylesheet" href="{{ asset('css/pages/reservation/create.css') }}">
@endsection
@section('content')
    <div class="reservation-make-wrapper">
        <div class="container">
            <form id="makeReservationForm" action="{{ route('reservation.store') }}" method="POST" autocomplete="off">
                @csrf
                <div class="page-title">
                    <h2>Make reservation</h2>
                    <hr>
                </div>
                <div class="section">
                    <div class="section-title">Payment information</div>
                    <div class="form-row">
                        <label for="cardType">Card type</label>
                        <select class="custom-select" id="cardType" name="cardType">
                            <option value="AX">American Express</option>
                            <option value="MC">Master Card</option>
                            <option value="VI">Visa</option>
                        </select>
                    </div>
                    <div class="form-row">
                        <label for="cardName">Name on card</label>
                        <input type="text" id="cardName" maxlength="100" name="cardName" value="{{ old('cardName') }}">
                        <span id="cardNameError" class="error-message">
                            @error('cardName')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>
                    <div class="form-row">
                        <label for="cardNumber">Card number</label>
                        <input type="text" id="cardNumber" maxlength="19" name="cardNumber"
                            value="{{ old('cardNumber') }}">
                        <span id="cardNumberError" class="error-message">
                            @error('cardNumber')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>
                    <div class="expiration-form-row">
                        <div class="row-title">
                            Card expiration date
                        </div>
                        <div class="row">
                            <div class="form-row">
                                <label for="cardExpirationMonth">Month</label>
                                <select class="custom-select" name="cardExpirationMonth">
                                    <option value="01">January</option>
                                    <option value="02">February</option>
                                    <option value="03">March</option>
                                    <option value="04">April</option>
                                    <option value="05">May</option>
                                    <option value="06">June</option>
                                    <option value="07">July</option>
                                    <option value="08">August</option>
                                    <option value="09">September</option>
                                    <option value="10">October</option>
                                    <option value="11">November</option>
                                    <option value="12">December</option>
                                </select>
                                <span id="cardExpirationMonthError" class="error-message"></span>
                            </div>
                            <div class="form-row">
                                <label for="cardExpirationYear">Year</label>
                                <select class="custom-select" id="cardExpirationYear" name="cardExpirationYear"></select>
                                <span id="cardExpirationYearError" class="error-message"></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <label for="CVVCode">CVV CODE</label>
                        <input type="text" id="CVVCode" maxlength="5" name="CVVCode" value="{{ old('CVVCode') }}">
                        <span id="CVVCodeError" class="error-message">
                            @error('CVVCode')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>
                </div>
                <div class="section">
                    <div class="section-title">Message</div>
                    <div class="form-row">
                        <label for="message">Enter any speacial requests for your stay (optional) </label>
                        <textarea type="text" id="message" rows="3" maxlength="300" name="message" value="{{ old('message') }}"></textarea>
                    </div>
                </div>
                <div class="form-row create-reservation-submit-button">
                    <button class="submit-button" type="submit">Make reservation</button>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ asset('js/reservation/create/index.js') }}"></script>
@endsection
