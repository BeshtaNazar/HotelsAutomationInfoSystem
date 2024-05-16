@extends('components.layout')
@section('title', 'List Rooms | Hotels Automation')
@section('css')
    <link rel="stylesheet" href="{{ asset('css/pages/room/index.css') }}">
@endsection
@section('content')
    <div class="hotel-rooms-wrapper">
        <div class="container">
            <div class="hotel-page">
                <div class="hotel-header">
                    <div class="hotel-title">
                        <h2>{{ $hotel->name . ' Hotel' }}</h2>
                        <span>{{ $hotel->building_number . ' ' . $hotel->street . ',' . $hotel->city }}</span>
                    </div>
                </div>
                <ul class="nav">
                    <li><a href="{{ route('hotel.preview', ['hotelName' => $hotel->name]) }}">Overview</a></li>
                    <li class="active"><a href="{{ route('rooms.preview', ['hotelName' => $hotel->name]) }}">Rooms</a></li>
                </ul>
                <div class="available-rooms-form" id="available-rooms-form">
                    <div class="date-pickers">
                        <input type="date">
                        <input type="date">
                    </div>
                    <button class="submit-button">View</button>
                </div>
                <div class="rooms-col">
                    @foreach ($hotel->getHotelRooms()->get() as $room)
                        <div class="list-row">
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
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')

@endsection
