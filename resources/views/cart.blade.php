@extends('components.layout')
@section('title', 'Cart | Hotels Automation')
@section('css')
    <link rel="stylesheet" href="{{ asset('css/cart.css') }}">
@endsection
@section('content')
    <div class="cart-wrapper">
        <div class="container">
            <div class="rooms-col">
                @foreach ($rooms as $room)
                    <div class="list-row item-room" data-room-price="{{ $room->price_for_night }}"
                        data-check-in="{{ $room->checkIn }}" data-check-out="{{ $room->checkOut }}">
                        @if (!$room->isAvailable)
                            <div class="unavailable-cover"></div>
                            <span class="unavailable-text">Unavailable</span>
                        @endif
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
                            <div class="row">
                                Hotel : {{ $room->hotel->name }}
                            </div>
                            <div class="row">
                                Check-in - Check-out : <br>{{ $room->checkIn . ' | ' . $room->checkOut }}
                            </div>
                        </div>
                        <div class="actions">
                            <button data-room-id="{{ $room->id }}"
                                onclick="deleteRoomFromCart({{ $room->id }},this,true)" class="unreserve-btn">
                                Delete from cart</button>
                        </div>
                    </div>
                @endforeach
            </div>
            @if ($rooms->isEmpty())
                <div class="not-found-message">
                    Cart is empty.
                </div>
            @else
                <div class="submit-cart">
                    <div class="total-price">Total: <span id="total-price"></span> USD</div>
                    <div class="continue-link">
                        <a href="{{ route('reservation.create') }}">Make reservation</a>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ asset('js/cart/index.js') }}"></script>
@endsection
