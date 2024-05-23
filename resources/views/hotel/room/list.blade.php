@extends('components.layout')
@section('title', 'List Rooms | Hotels Automation')
@section('css')
    <link rel="stylesheet" href="{{ asset('css/pages/room/list.css') }}">
@endsection
@section('content')
    <div class="list-rooms-wrapper">
        <div class="container">
            <div class="page-title">
                <h2>{{ $hotelName }} rooms</h2>
                <hr>
            </div>
            @foreach ($rooms as $room)
                <div class="list-row">
                    <div>
                        <div class="row row-room-type">
                            Type : {{ $room->room_type }}
                        </div>
                        <div class="row-info">
                            <div class="col">
                                Guests : {{ $room->number_of_guests }}
                            </div>
                            <div class="col">
                                Smoking : @if ($room->is_smoking_allowed)
                                    yes
                                @else
                                    no
                                @endif
                            </div>
                            <div class="col">
                                Size : {{ $room->size . ' of ' . $room->measure_unit }}
                            </div>
                            <div class="col">
                                Price : {{ $room->price_for_night }}
                            </div>
                        </div>
                        <div class="beds-info">
                            Beds:
                            @foreach ($beds = $room->beds()->get() as $bed)
                                @if ($beds->last() == $bed)
                                    {{ $bed->pivot->count . ' ' . $bed->name . ' bed' }}
                                @else
                                    {{ $bed->pivot->count . ' ' . $bed->name . ' bed +' }}
                                @endif
                            @endforeach
                        </div>
                    </div>
                    <div class="actions">
                        <form
                            action="{{ $isActive ? route('room.delete.active', ['room' => $room->id]) : route('room.delete', ['room' => $room->id]) }}"
                            method="POST">
                            @csrf
                            @if ($isActive)
                                @method('PUT')
                            @else
                                @method('DELETE')
                            @endif
                            <button type="submit" class="delete-button">Delete</button>
                        </form>
                        <a href="{{ route('room.edit', ['hotelName' => $hotelName, 'room' => $room]) }}"
                            class="change-link">Edit</a>
                    </div>
                </div>
            @endforeach
            <div class="rooms-links">
                <div class="add-link">
                    <a href="{{ route('room.create', ['hotelName' => $hotelName]) }}">Add new room</a>
                </div>
                <div class="continue-link">
                    <a
                        href="{{ $isActive ? route('hotel.manage') : route('hotel.upload.photo', ['hotelName' => $hotelName]) }}">Continue</a>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')

@endsection
