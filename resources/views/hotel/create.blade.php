@extends('components.layout')
@section('title', 'List Hotel | Hotels Automation')
@section('css')
    <link rel="stylesheet" href="{{ asset('css/pages/hotel/create.css') }}">
@endsection
@section('content')
    <div class="list-wrapper">
        <div class="container">
            <form id="listHotelForm"
                action="{{ isset($hotel) ? route('hotel.update', ['hotel' => $hotel]) : route('hotel.store') }}"
                method="POST" autocomplete="off">
                @csrf
                @if (isset($hotel))
                    @method('PUT')
                @endif

                <div class="page-title">
                    <h2>List hotel</h2>
                    <hr>
                </div>
                <div class="form-row">
                    <label for="hotelName">Hotel name</label>
                    <input type="text" id="hotelName" maxlength="100" name="hotelName" value="{{ $hotel->name ?? '' }}">
                    <span id="hotelNameError" class="error-message"></span>
                </div>
                <div class="form-row checkbox-row">
                    <input type="checkbox" @if ($hotel->are_children_allowed ?? 0 != 0) checked @endif name="areChildrenAllowed"
                        id="areChildrenAllowed">
                    <label for="areChildrenAllowed">Children allowed</label>
                </div>
                <div class="form-row checkbox-row">
                    <input type="checkbox" @if ($hotel->are_pets_allowed ?? 0 != 0) checked @endif name="arePetsAllowed"
                        id="arePetsAllowed">
                    <label for="arePetsAllowed">Pets allowed</label>
                </div>
                <div class="time-form-row arrival-form-row form-row">
                    <div class="input-row">
                        <div class="form-row">
                            <div class="tooltip-label">
                                <label for="arrivalTimeFrom">Arrival from</label>
                                <div class="tooltip">
                                    <div class="tooltip-mark">?</div>
                                    <div class="tooltip-text">Choose time from when guests can check-in</div>
                                </div>
                            </div>
                            <select class="custom-select" id="arrivalTimeFrom" name="arrivalTimeFrom">
                                @for ($i = 0; $i < 24; $i++)
                                    <option value="{{ $i }}" @if (isset($hotel) && $i == $hotel->arrival_time_from) selected @endif>
                                        {{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="form-row">
                            <div class="tooltip-label">
                                <label for="arrivalTimeTo">Arrival to</label>
                                <div class="tooltip">
                                    <div class="tooltip-mark">?</div>
                                    <div class="tooltip-text">Choose time to when guests can check-in</div>
                                </div>
                            </div>
                            <select class="custom-select" id="arrivalTimeTo" name="arrivalTimeTo">
                                @for ($i = 0; $i < 24; $i++)
                                    <option value="{{ $i }}" @if (isset($hotel) && $i == $hotel->arrival_time_to ?? null) selected @endif>
                                        {{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>
                    <span id="arrivalError" class="error-message"></span>
                </div>
                <div class="time-form-row departure-form-row form-row">
                    <div class="input-row">
                        <div class="form-row">
                            <div class="tooltip-label">
                                <label for="departureTimeFrom">Departure from</label>
                                <div class="tooltip">
                                    <div class="tooltip-mark">?</div>
                                    <div class="tooltip-text">Choose time from when guests can check-out</div>
                                </div>
                            </div>
                            <select class="custom-select" id="departureTimeFrom" name="departureTimeFrom">
                                @for ($i = 0; $i < 24; $i++)
                                    <option value="{{ $i }}" @if (isset($hotel) && $i == $hotel->departure_time_from ?? null) selected @endif>
                                        {{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="form-row">
                            <div class="tooltip-label">
                                <label for="departureTimeTo">Departure to</label>
                                <div class="tooltip">
                                    <div class="tooltip-mark">?</div>
                                    <div class="tooltip-text">Choose time to when guests can check-out</div>
                                </div>
                            </div>
                            <select class="custom-select" id="departureTimeTo" name="departureTimeTo">
                                @for ($i = 0; $i < 24; $i++)
                                    <option value="{{ $i }}" @if (isset($hotel) && $i == $hotel->departure_time_to ?? null) selected @endif>
                                        {{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>
                    <span id="departureError" class="error-message"></span>
                </div>
                <div class="form-row">
                    <div class="tooltip-label">
                        <label for="cancelationPolicyDays">Cancelation policy days</label>
                        <div class="tooltip">
                            <div class="tooltip-mark">?</div>
                            <div class="tooltip-text">Input number of days before check-in when client can't get money back
                                for canceling, leave empty if you don't want to return money for canceled reservations</div>
                        </div>
                    </div>
                    <input type="number" id="cancelationPolicyDays" name="cancelationPolicyDays"
                        value="{{ $hotel->cancelation_policy_days ?? '' }}">
                    <span id="cancelationPolicyDaysError" class="error-message"></span>
                </div>
                <div class="form-row">
                    <label for="buildingNumber">Building number</label>
                    <input type="number" id="buildingNumber" name="buildingNumber"
                        value="{{ $hotel->building_number ?? '' }}">
                    <span id="buildingNumberError" class="error-message"></span>
                </div>
                <div class="form-row">
                    <label for="street">Street</label>
                    <input type="text" id="street" name="street" value="{{ $hotel->street ?? '' }}">
                    <span id="streetError" class="error-message"></span>
                </div>
                <div class="form-row">
                    <label for="city">City</label>
                    <input type="text" id="city" name="city" value="{{ $hotel->city ?? '' }}">
                    <span id="cityError" class="error-message"></span>
                </div>
                <div class="form-row">
                    <label for="country">Country</label>
                    <select class="custom-select register-page-select" name="country">
                        @foreach ($countries as $country)
                            <option value="{{ $country }}" @if (isset($hotel) && $country == $hotel->country ?? null) selected @endif>
                                {{ $country }}</option>
                        @endforeach
                    </select>
                    <span id="countryError" class="error-message"></span>
                </div>
                <div class="form-row">
                    <label for="postalCode">Postal code</label>
                    <input type="text" id="postalCode" name="postalCode" value="{{ $hotel->postal_code ?? '' }}">
                    <span id="postalCodeError" class="error-message"></span>
                </div>
                <div class="form-row">
                    <label for="iban">IBAN</label>
                    <input type="text" id="iban" name="iban" value="{{ $hotel->iban ?? '' }}">
                    <span id="ibanError" class="error-message"></span>
                </div>
                <div class="form-row list-hotel-submit-button">
                    <button class="submit-button" type="submit">{{ $isActive ? 'Update' : 'Continue' }}</button>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ asset('js/list-hotel/validateInputs.js') }}"></script>
@endsection
