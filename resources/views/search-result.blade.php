@extends('components.layout')
@section('title', 'Search Result | Hotels Automation')
@section('css')
    <link rel="stylesheet" href="{{ asset('css/pages/search.css') }}">
@endsection
@section('content')
    <div class="search-wrapper">
        <div class="search-property-bar">
            <form action="{{ route('search.result') }}" method="GET" autocomplete="off">
                <div class="search-details">
                    <div class="col col-location">
                        <label for="location">Hotel, city or country</label>
                        <input type="text" required name="location" class="form-input"
                            value="{{ isset($request) ? $request->location : '' }}">
                    </div>
                    <div class="col col-date-pickers">
                        <div class="col col-checkin">
                            <label for="checkin">Check-in</label>
                            <input type="date" required name="checkIn" class="form-input"
                                value="{{ isset($request) ? $request->checkIn : '' }}">
                        </div>
                        <div class="col col-checkout">
                            <label for="checkout">Check-out</label>
                            <input type="date" required name="checkOut" class="form-input"
                                value="{{ isset($request) ? $request->checkOut : '' }}">
                        </div>
                    </div>
                    <div class="col col-select">
                        <label for="rooms">Rooms</label>
                        <select name="rooms" id="roomSelect" class="custom-select">
                            @if (isset($request))
                                @for ($i = 1; $i <= 4; $i++)
                                    <option value = "{{ $i }}"
                                        {{ count($request->rooms) == $i ? 'selected' : '' }}>
                                        {{ $i }}
                                    </option>
                                @endfor
                            @else
                                @for ($i = 1; $i <= 4; $i++)
                                    <option value = "{{ $i }}">{{ $i }}
                                    </option>
                                @endfor
                            @endif
                        </select>
                    </div>
                    <div class="col col-select col-guests">
                        <label for="adults">Adults</label>
                        <select name="rooms[0][adults]" id="adultSelect" class="custom-select">
                            @if (isset($request))
                                @for ($i = 1; $i <= 7; $i++)
                                    <option value = "{{ $i }}"
                                        {{ $request->rooms[0]['adults'] == $i ? 'selected' : '' }}>
                                        {{ $i }}
                                    </option>
                                @endfor
                            @else
                                @for ($i = 1; $i <= 7; $i++)
                                    <option value = "{{ $i }}">{{ $i }}
                                    </option>
                                @endfor
                            @endif
                        </select>
                        <input readonly id="adultNum" value="1" class="custom-select form-input"
                            style="display: none">
                    </div>
                    <div class="col col-select col-guests">
                        <label for="children">Children</label>
                        <select name="rooms[0][children]" id="childrenSelect" class="custom-select">
                            @if (isset($request))
                                @for ($i = 0; $i <= 7; $i++)
                                    <option value = "{{ $i }}"
                                        {{ $request->rooms[0]['children'] == $i ? 'selected' : '' }}>
                                        {{ $i }}
                                    </option>
                                @endfor
                            @else
                                @for ($i = 0; $i <= 7; $i++)
                                    <option value = "{{ $i }}">{{ $i }}
                                    </option>
                                @endfor
                            @endif
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
                        @if (isset($request))
                            @foreach ($request->rooms as $key => $room)
                                <input type="hidden" id="rooms[{{ $key }}][adults]"
                                    value="{{ $room['adults'] }}">
                                <input type="hidden" class="rooms" id="rooms[{{ $key }}][children]"
                                    value="{{ $room['children'] }}">
                            @endforeach
                        @endif
                    </div>
                </div>
            </form>
        </div>

        <div class="hotels">
            @foreach ($hotels as $hotel)
                <div class="list-row">
                    <div class="col-info">
                        <div class="col-hotel-media">
                            <img src="{{ ($image = $hotel->getMedia('hotels_images')->first())->getAvailableUrl(['preview']) }}"
                                alt="{{ $image->name }}">
                        </div>
                        <div class="col-hotel-info">
                            <div class="row row-hotel-name"> <a
                                    href="{{ route('hotel.show', ['hotelName' => $hotel->name]) }}">{{ $hotel->name }}</a>
                            </div>
                            <div class="row row-hotel-address">
                                {{ $hotel->city . ', ' . $hotel->country }}</div>
                            <div class="row row-avg-price">
                                Avg room price: {{ number_format($hotel->rooms()->get()->avg('price_for_night'), 2) }} USD
                            </div>
                        </div>
                    </div>
                    <div class="col-links">
                        <a href="{{ route('rooms.show.available', array_merge(['hotelName' => $hotel->name], $request->query())) }}"
                            class="reserve-link">Reserve</a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ asset('js/datepickersLimits.js') }}"></script>
    <script src="{{ asset('js/roomListGeneration.js') }}"></script>
@endsection
