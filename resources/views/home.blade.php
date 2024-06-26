@extends('components.layout')
@section('title', 'Hotels Automation')
@section('css')
    <link rel="stylesheet" href="{{ asset('css/pages/home.css') }}">
@endsection
@section('content')
    <div class="home-image">
        <img src="/images/app/home-image.jpg"" alt="">
    </div>
    <div class="home-wrapper">
        <div class="search-property-bar">
            <form action="{{ route('search.result') }}" method="GET" autocomplete="off">
                <div class="search-details">
                    <div class="col col-location">
                        <label for="location">Hotel, city or country</label>
                        <input type="text" required name="location" class="form-input">
                    </div>
                    <div class="col col-date-pickers">
                        <div class="col col-checkin">
                            <label for="checkin">Check-in</label>
                            <input type="date" required name="checkIn" class="form-input">
                        </div>
                        <div class="col col-checkout">
                            <label for="checkout">Check-out</label>
                            <input type="date" required name="checkOut" class="form-input">
                        </div>
                    </div>
                    <div class="col col-select">
                        <label for="rooms">Rooms</label>
                        <select name="rooms" id="roomSelect" class="custom-select">
                            <option>1</option>
                            <option>2</option>
                            <option>3</option>
                            <option>4</option>
                        </select>
                    </div>
                    <div class="col col-select col-guests">
                        <label for="adults">Adults</label>
                        <select name="rooms[0][adults]" id="adultSelect" class="custom-select">
                            <option>1</option>
                            <option>2</option>
                            <option>3</option>
                            <option>4</option>
                            <option>5</option>
                            <option>6</option>
                            <option>7</option>
                        </select>
                        <input readonly id="adultNum" value="1" class="custom-select form-input"
                            style="display: none">
                    </div>
                    <div class="col col-select col-guests">
                        <label for="children">Children</label>
                        <select name="rooms[0][children]" id="childrenSelect" class="custom-select">
                            <option>0</option>
                            <option>1</option>
                            <option>2</option>
                            <option>3</option>
                            <option>4</option>
                            <option>5</option>
                            <option>6</option>
                            <option>7</option>
                        </select>
                        <input readonly id="childrenNum" value="0" class="custom-select form-input"
                            style="display: none">
                    </div>
                    <div class="col col-button">
                        <button type="submit" class="submit-prop-search-btn">Search</button>
                    </div>
                </div>
                <div class="room-list" id="roomList" style="height: 0px">
                    <hr>
                    <span>
                    </span>
                    <div class="room-list-row">
                        <div class="col col-button">
                            <a class="close-room-list-button">Close</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ asset('js/datepickersLimits.js') }}"></script>
    <script src="{{ asset('js/roomListGeneration.js') }}"></script>
    <script src="{{ asset('js/submitPropertySearchForm.js') }}"></script>
@endsection
