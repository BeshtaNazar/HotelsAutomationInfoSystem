@extends('components.layout')
@section('title', 'Manage Hotels | Hotels Automation')
@section('css')
    <link rel="stylesheet" href="{{ asset('css/pages/hotel/manage.css') }}">
@endsection
@section('content')
    <div class="manage-hotels-wrapper">
        <div class="container">
            @if (!empty(session('success')))
                <div role="alert" class="alert-message success-message">
                    {{ session('success') }}
                </div>
            @endif
            <div class="page-title">
                <h2>Manage hotels</h2>
                <hr>
            </div>
            @if (!$activeHotels->isEmpty())
                <div class="row-title">
                    Active hotels
                </div>
                @foreach ($activeHotels as $activeHotel)
                    <div class="list-row">
                        <div>
                            <div class="row row-hotel-media">

                                @foreach ($activeHotel->getMedia('hotels_images') as $image)
                                    <img src="{{ $image->getAvailableUrl(['preview']) }}" alt="{{ $image->name }}">
                                @endforeach
                            </div>
                            <div class="row row-hotel-name">
                                Name : {{ $activeHotel->name }}
                            </div>
                            <div class="row-info">
                                <div class="col">
                                    Room count :
                                    {{ $activeHotel->rooms()->where('status', App\Enums\RoomStatus::ACTIVE->value)->count() }}
                                </div>
                                <div class="col">
                                    Children : @if ($activeHotel->are_children_allowed)
                                        yes
                                    @else
                                        no
                                    @endif
                                </div>
                                <div class="col">
                                    Pets : @if ($activeHotel->are_pets_allowed)
                                        yes
                                    @else
                                        no
                                    @endif
                                </div>
                                <div class="col">
                                    Arrival :
                                    {{ sprintf('%02d:00', $activeHotel->arrival_time_from) . '-' . sprintf('%02d:00', $activeHotel->arrival_time_to) }}
                                </div>
                                <div class="col">
                                    Departure :
                                    {{ sprintf('%02d:00', $activeHotel->departure_time_from) . '-' . sprintf('%02d:00', $activeHotel->departure_time_to) }}
                                </div>
                                <div class="col">
                                    Policy days : {{ $activeHotel->cancelation_policy_days }}
                                </div>
                                <div class="col">
                                    Address:
                                    {{ $activeHotel->building_number . ' ' . $activeHotel->street . ' ' . $activeHotel->city . ',' . $activeHotel->country }}
                                </div>
                                <div class="col">
                                    IBAN : {{ $activeHotel->iban }}
                                </div>
                            </div>
                        </div>
                        <div class="actions">
                            <a href="{{ route('hotel.reservations', ['hotelName' => $activeHotel->name]) }}"
                                class="change-link">Reservations</a>
                            <a href="{{ route('hotel.edit', ['hotelName' => $activeHotel->name]) }}"
                                class="change-link">Update hotel info</a>
                            <a href="{{ route('room.list', ['hotelName' => $activeHotel->name]) }}"
                                class="change-link">Update rooms info</a>
                            <a href="{{ route('hotel.upload.photo', ['hotelName' => $activeHotel->name]) }}"
                                class="change-link">Update photo of hotel</a>
                            <form action="{{ route('hotel.delete.active', ['hotel' => $activeHotel->id]) }}"
                                method="POST">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="delete-button">Delete</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            @endif
            @if (!$inactiveHotels->isEmpty())
                <div class="row-title">
                    Inactive hotels
                </div>
                @foreach ($inactiveHotels as $inactiveHotel)
                    <div class="list-row">
                        <div>
                            <div class="row row-hotel-media">
                                @foreach ($inactiveHotel->getMedia('hotels_images') as $image)
                                    <img src="{{ $image->getAvailableUrl(['preview']) }}" alt="{{ $image->name }}">
                                @endforeach

                            </div>
                            <div class="row row-hotel-name">
                                Name : {{ $inactiveHotel->name }}
                            </div>
                            <div class="row-info">
                                <div class="col">
                                    Room count : {{ $inactiveHotel->rooms()->count() }}
                                </div>
                                <div class="col">
                                    Children : @if ($inactiveHotel->are_children_allowed)
                                        yes
                                    @else
                                        no
                                    @endif
                                </div>
                                <div class="col">
                                    Pets : @if ($inactiveHotel->are_pets_allowed)
                                        yes
                                    @else
                                        no
                                    @endif
                                </div>
                                <div class="col">
                                    Arrival :
                                    {{ sprintf('%02d:00', $inactiveHotel->arrival_time_from) . '-' . sprintf('%02d:00', $inactiveHotel->arrival_time_to) }}
                                </div>
                                <div class="col">
                                    Departure :
                                    {{ sprintf('%02d:00', $inactiveHotel->departure_time_from) . '-' . sprintf('%02d:00', $inactiveHotel->departure_time_to) }}
                                </div>
                                <div class="col">
                                    Policy days : {{ $inactiveHotel->cancelation_policy_days }}
                                </div>
                                <div class="col">
                                    Address:
                                    {{ $inactiveHotel->building_number . ' ' . $inactiveHotel->street . ' ' . $inactiveHotel->city . ', ' . $inactiveHotel->country }}
                                </div>
                                <div class="col">
                                    IBAN : {{ $inactiveHotel->iban }}
                                </div>
                            </div>
                        </div>
                        <div class="inactive-hotel-actions">
                            <form action="{{ route('hotel.delete', ['hotel' => $inactiveHotel->id]) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="delete-button">Delete</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            @endif
            <div class="add-link">
                <a href="{{ route('hotel.list') }}">List new hotel</a>
            </div>
        </div>
    </div>
    </div>
@endsection
@section('script')

@endsection
