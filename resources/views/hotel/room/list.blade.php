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
                        {{ $room->room_type }}
                    </div>
                    <div>
                        <form action="{{ route('room.delete', ['room' => $room->id]) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="delete-button">Delete</button>
                        </form>
                        <a href="{{ route('room.edit.new', ['hotelName' => $hotelName, 'room' => $room]) }}"
                            class="change-link">Edit</a>
                    </div>
                </div>
            @endforeach
            <div class="add-link">
                <a href="{{ route('room.create', ['hotelName' => $hotelName]) }}">Add new room</a>
            </div>
            <div class="continue-link">
                <a href="{{ route('hotel.upload.photo', ['hotelName' => $hotelName]) }}">Continue</a>
            </div>
        </div>
    </div>
@endsection
@section('script')

@endsection
