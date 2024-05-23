@extends('components.layout')
@section('title', $hotel->name . ' Rooms | Hotels Automation')
@section('css')
    <link rel="stylesheet" href="{{ asset('css/pages/room/index.css') }}">
@endsection
@section('content')
    <div class="hotel-rooms-wrapper">
        <div class="container">
            <div class="hotel-page">
                <div class="hotel-header">
                    <div class="hotel-title">
                        <h2>{{ $hotel->name }}</h2>
                        <span>{{ $hotel->building_number . ' ' . $hotel->street . ',' . $hotel->city }}</span>
                    </div>
                </div>
                <ul class="nav">
                    <li><a
                            href="{{ $isPreview ? route('hotel.preview', ['hotelName' => $hotel->name]) : route('hotel.show', ['hotelName' => $hotel->name]) }}">Overview</a>
                    </li>
                    <li class="active"><a
                            href="{{ $isPreview ? route('rooms.preview', ['hotelName' => $hotel->name]) : route('rooms.show', ['hotelName' => $hotel->name]) }}">Rooms</a>
                    </li>
                </ul>
                <form action="{{ route('rooms.show.available', ['hotelName' => $hotel->name]) }}"
                    class="available-rooms-form" method="GET" id="available-rooms-form" autocomplete="off">
                    @csrf
                    <div class="col-date-picker">
                        <label for="checkIn">Check-in</label>
                        <input type="date" id="checkIn" name="checkIn"
                            value="{{ old('checkIn') ?? isset($request->checkIn) ? $request->checkIn : '' }}">
                        <span id="checkInError" class="error-message">
                            @error('checkIn')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>
                    <div class="col-date-picker">
                        <label for="checkOut">Check-out</label>
                        <input type="date" id="checkOut" name="checkOut"
                            value="{{ old('checkOut') ?? isset($request->checkOut) ? $request->checkOut : '' }}">
                        <span id="checkOutError" class="error-message">
                            @error('checkOut')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>
                    <button @class(['disabled-btn' => $isPreview, 'submit-button'])>View availability</button>
                </form>
                <a href="{{ $isPreview ? route('rooms.preview', ['hotelName' => $hotel->name]) : route('rooms.show', ['hotelName' => $hotel->name]) }}"
                    class="show-all-rooms-link">Show All
                    Rooms</a>
                <div class="rooms-col">
                    <div class="row-title">
                        {{ (isset($isSearch) ? $availableRooms->count() : $rooms->count()) . ' Available Rooms' }}
                    </div>
                    @foreach (isset($isSearch) ? $availableRooms : $rooms as $room)
                        <div class="list-row item-room">
                            <div class="room-info">
                                <div class="row">
                                    {{ $room->room_type }}
                                </div>
                                <div class="row">
                                    Sleeps : {{ $room->number_of_guests }}
                                </div>
                                <div class="row">
                                    @foreach ($beds = $room->beds()->get() as $bed)
                                        @if ($beds->last() == $bed)
                                            {{ $bed->pivot->count . ' ' . $bed->name . ' bed' }}
                                        @else
                                            {{ $bed->pivot->count . ' ' . $bed->name . ' bed +' }}
                                        @endif
                                    @endforeach
                                </div>
                                <div class="row">
                                    Size : {{ $room->size . ' of ' . $room->measure_unit }}
                                </div>
                                <div class="row">
                                    Smoking is {{ $room->is_smoking_allowed != 0 ? 'allowed' : 'NOT allowed' }}
                                </div>
                                <div class="row">
                                    Price for night : {{ $room->price_for_night }} USD
                                </div>
                            </div>
                            @if (isset($isSearch))
                                <div class="actions">
                                    <button data-room-id="{{ $room->id }}"
                                        onclick="addRoomToCart({{ $room->id }},this)" @class(['disabled-btn' => $isPreview, 'reserve-btn'])
                                        class="reserve-btn">
                                        Add to cart</button>
                                    <button data-room-id="{{ $room->id }}"
                                        onclick="deleteRoomFromCart({{ $room->id }},this)" @class(['disabled-btn' => $isPreview, 'unreserve-btn', 'hidden'])
                                        class="unreserve-btn hidden">
                                        Delete from cart</button>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
                @if (isset($isSearch))
                    <div class="cart-link">
                        <a href="{{ route('cart') }}">Go to cart</a>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ asset('js/room/index/index.js') }}"></script>
@endsection
