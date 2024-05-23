@extends('components.layout')
@section('title', (isset($isHotel) ? $hotelName : '') . ' Reservations | Hotels Automation')
@section('css')
    <link rel="stylesheet" href="{{ asset('css/pages/reservation/index.css') }}">
@endsection
@section('content')
    <div class="account-reservations-wrapper">
        <div class="container">
            @if ($activeReservations->isEmpty() && $pastReservations->isEmpty() && $canceledReservations->isEmpty())
                <div class="not-found-message">
                    Reservations are not found
                </div>
            @endif
            @if (!$activeReservations->isEmpty())
                <div class="row-title">
                    Active reservations
                </div>
                @foreach ($activeReservations as $reservation)
                    <div class="list-row item-reservation">
                        <div class="room-info">
                            <div class="row">
                                Check-in: {{ $reservation->date_from }}
                            </div>
                            <div class="row">
                                Check-out: {{ $reservation->date_to }}
                            </div>
                            <div class="row">
                                Room Type: {{ $reservation->room->room_type }}
                            </div>
                            <div class="row">
                                Sleeps: {{ $reservation->room->number_of_guests }}
                            </div>
                            <div class="row">
                                Price for night: {{ $reservation->room->price_for_night }}
                            </div>
                            <div class="row">
                                Days before check-in when money can't be returned:
                                {{ $reservation->room->hotel->cancelation_policy_days }}
                            </div>
                            <div class="row">
                                Total: {{ $reservation->payment->amount }} USD
                            </div>
                            @if (isset($isHotel))
                                <div class="row">
                                    User first name:
                                    {{ $reservation->user->first_name }}
                                </div>
                                <div class="row">
                                    User last name:
                                    {{ $reservation->user->last_name }}
                                </div>
                                <div class="row">
                                    User phone:
                                    {{ $reservation->user->phone }}
                                </div>
                                <div class="row">
                                    User email:
                                    {{ $reservation->user->email }}
                                </div>
                                @if (!is_null($reservation->message))
                                    <div class="row">
                                        User message:
                                        {{ $reservation->message }}
                                    </div>
                                @endif
                            @endif
                        </div>
                        @if (!isset($isHotel))
                            <div class="actions">
                                <form action="{{ route('reservation.cancel', ['reservation' => $reservation->id]) }}"
                                    method="POST">
                                    @csrf
                                    @method('PUT')
                                    <button class="delete-button">Cancel</button>
                                </form>
                            </div>
                        @endif
                    </div>
                @endforeach
            @endif
            @if (!$pastReservations->isEmpty())
                <div class="row-title">
                    Past reservations
                </div>
                @foreach ($pastReservations as $reservation)
                    <div class="list-row item-reservation">
                        <div class="room-info">
                            <div class="row">
                                Check-in: {{ $reservation->date_from }}
                            </div>
                            <div class="row">
                                Check-out: {{ $reservation->date_to }}
                            </div>
                            <div class="row">
                                Room Type: {{ $reservation->room->room_type }}
                            </div>
                            <div class="row">
                                Sleeps: {{ $reservation->room->number_of_guests }}
                            </div>
                            <div class="row">
                                Price for night: {{ $reservation->room->price_for_night }}
                            </div>
                            <div class="row">
                                Total: {{ $reservation->payment->amount }} USD
                            </div>
                            @if (isset($isHotel))
                                <div class="row">
                                    User first name:
                                    {{ $reservation->user->first_name }}
                                </div>
                                <div class="row">
                                    User last name:
                                    {{ $reservation->user->last_name }}
                                </div>
                                <div class="row">
                                    User phone:
                                    {{ $reservation->user->phone }}
                                </div>
                                <div class="row">
                                    User email:
                                    {{ $reservation->user->email }}
                                </div>
                                @if (!is_null($reservation->message))
                                    <div class="row">
                                        User message:
                                        {{ $reservation->message }}
                                    </div>
                                @endif
                            @endif
                        </div>
                    </div>
                @endforeach
            @endif
            @if (!$canceledReservations->isEmpty())
                <div class="row-title">
                    Canceled reservations
                </div>
                @foreach ($canceledReservations as $reservation)
                    <div class="list-row item-reservation">
                        <div class="room-info">
                            <div class="row">
                                Check-in: {{ $reservation->date_from }}
                            </div>
                            <div class="row">
                                Check-out: {{ $reservation->date_to }}
                            </div>
                            <div class="row">
                                Room Type: {{ $reservation->room->room_type }}
                            </div>
                            <div class="row">
                                Sleeps: {{ $reservation->room->number_of_guests }}
                            </div>
                            <div class="row">
                                Price for night: {{ $reservation->room->price_for_night }}
                            </div>
                            <div class="row">
                                Total: {{ $reservation->payment->amount }} USD
                            </div>
                            @if (isset($isHotel))
                                <div class="row">
                                    User first name:
                                    {{ $reservation->user->first_name }}
                                </div>
                                <div class="row">
                                    User last name:
                                    {{ $reservation->user->last_name }}
                                </div>
                                <div class="row">
                                    User phone:
                                    {{ $reservation->user->phone }}
                                </div>
                                <div class="row">
                                    User email:
                                    {{ $reservation->user->email }}
                                </div>
                                @if (!is_null($reservation->message))
                                    <div class="row">
                                        User message:
                                        {{ $reservation->message }}
                                    </div>
                                @endif
                            @endif
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
@endsection
@section('script')
@endsection
