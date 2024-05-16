@extends('components.layout')
@section('title', 'Create Room | Hotels Automation')
@section('css')
    <link rel="stylesheet" href="{{ asset('css/pages/room/create.css') }}">
@endsection
@section('content')
    <div class="edit-room-wrapper">
        <div class="container">
            <form id="editRoomForm"
                action="{{ isset($room) ? route('room.update', ['room' => $room]) : route('room.store', ['hotelName' => $hotelName]) }}"
                method="POST" autocomplete="off">
                @csrf

                @if (isset($room))
                    @method('PUT')
                    <div class="page-title">
                        <h2>Edit room</h2>
                        <hr>
                    </div>
                @else
                    <div class="page-title">
                        <h2>Create room</h2>
                        <hr>
                    </div>
                @endif

                <div class="form-row">
                    <label for="numberOfGuests">Number of guests in room</label>
                    <input type="number" id="numberOfGuests" name="numberOfGuests"
                        value="{{ $room->number_of_guests ?? old('numberOfGuests') }}">
                    <span id="numberOfGuestsError" class="error-message">
                        @error('numberOfGuests')
                            {{ $message }}
                        @enderror
                    </span>
                </div>
                <div class="form-row checkbox-row">
                    <input type="checkbox" name="isSmokingAllowed" id="isSmokingAllowed"
                        @if ($room->is_smoking_allowed ?? 0 != 0 || !is_null(old('isSmokingAllowed'))) checked @endif>
                    <label for="isSmokingAllowed">Smoking allowed</label>
                </div>
                <div class="form-row">
                    <div class="table-row">
                        <div class="table-col room-size">
                            <label for="size">Room size</label>
                            <input type="number" id="size" name="size" value="{{ $room->size ?? old('size') }}">
                        </div>
                        <div class="table-col measure-unit">
                            <label for="measureUnit">Measure unit</label>
                            <select class="custom-select" name="measureUnit" id="measureUnit">
                                <option value="Square meters" @if (isset($room) ? $room->measure_unit == 'Square Meters' : old('measureUnit') == 'Square Meters') selected @endif>Square
                                    meters (m²)
                                </option>
                                <option value="Square feet" @if (isset($room) ? $room->measure_unit == 'Square feet' : old('measureUnit') == 'Square feet') selected @endif>Square feet
                                    (ft²)</option>
                            </select>
                        </div>
                    </div>
                    <span id="sizeError" class="error-message">
                        @error('size')
                            {{ $message }}
                        @enderror
                    </span>
                </div>
                <div class="form-row">
                    <label for="priceForNight">Price for night in USD</label>
                    <input type="number" id="priceForNight" name="priceForNight"
                        value="{{ $room->price_for_night ?? old('priceForNight') }}">
                    <span id="priceForNightError" class="error-message">
                        @error('priceForNight')
                            {{ $message }}
                        @enderror
                    </span>
                </div>
                <div class="form-row">

                    <label for="roomType">Room type</label>
                    <select name="roomType" id="roomType" class="custom-select">
                        @foreach ($roomTypes as $roomType)
                            <option value="{{ $roomType }}" @if (isset($room) ? $room->room_type == $roomType : old('roomType') == $roomType) selected @endif>
                                {{ $roomType }}</option>
                        @endforeach
                    </select>
                    <span id="roomTypeError" class="error-message"></span>
                </div>
                <div class="form-row">
                    <div class="beds-col">
                        <div class="form-row-title">
                            <h2>Beds</h2>
                        </div>
                        @foreach ($beds as $bed)
                            <div class="row">
                                <label for="{{ $bed->name }}Bed">{{ $bed->name }} bed count</label>
                                <input type="number" id="{{ $bed->name }}Bed" name="beds[{{ $bed->name }}]"
                                    @if (isset($room) &&
                                            ($attachedBed = $room->beds()->where('bed_id', $bed->id)->first())) value="{{ $attachedBed->pivot->count }}"
                                @else value="{{ is_null(old('beds.' . $bed->name)) ? 0 : old('beds.' . $bed->name) }}" @endif>
                            </div>
                        @endforeach
                    </div>
                    <span class="error-message">
                        @foreach ($beds as $bed)
                            @error('beds.' . $bed->name)
                                {{ $message }}
                                <br>
                            @enderror
                        @endforeach
                        @error('bedsCount')
                            {{ $message }}
                        @enderror
                    </span>
                </div>

                @if (!isset($room))
                    <div class="form-row">
                        <label for="roomsCount">Rooms count</label>
                        <input type="number" id="roomsCount" max="50" name="roomsCount"
                            value="{{ old('roomsCount') }}">
                        <span id="roomsCountError" class="error-message">
                            @error('roomsCount')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>
                @endif
                <div class="form-row">
                    <button class="submit-button" type="submit">Submit</button>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('script')

@endsection
