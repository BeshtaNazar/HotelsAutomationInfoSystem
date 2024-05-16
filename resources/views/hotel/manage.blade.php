@extends('components.layout')
@section('title', 'Manage Hotels | Hotels Automation')
@section('css')
    <link rel="stylesheet" href="{{ asset('css/pages/hotel/manage.css') }}">
@endsection
@section('content')
    <div class="manage-hotels-wrapper">
        <div class="container">
            <div class="page-title">
                <h2>Manage hotels</h2>
                <hr>
            </div>
            @if (!$inactiveHotels->isEmpty())
                <div class="row-title">
                    Inactive hotels
                </div>
                @foreach ($inactiveHotels as $inactiveHotel)
                    <div class="list-row">
                        <div>
                            <div class="row row-hotel-media">
                                @foreach ($inactiveHotel->getMedia('hotels_images') as $image)
                                    <img src="{{ $image->getUrl() }}" alt="{{ $image->name }}">
                                @endforeach

                            </div>
                            <div class="row row-hotel-name">
                                Name : {{ $inactiveHotel->name }}
                            </div>
                            <div class="row-info">
                                <div class="col">
                                    Room count : {{ $inactiveHotel->getHotelRooms()->count() }}
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
                                    {{ $inactiveHotel->building_number . ' ' . $inactiveHotel->street . ' ' . $inactiveHotel->city . ' ' . $inactiveHotel->postal_code . ' ' . $inactiveHotel->country }}
                                </div>
                                <div class="col">
                                    IBAN : {{ $inactiveHotel->iban }}
                                </div>
                            </div>
                        </div>
                        <div class="hotel-actions">
                            <form action="{{ route('hotel.delete', ['hotel' => $inactiveHotel->id]) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="delete-button">Delete</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            @endif
            @if (!$activeHotels->isEmpty())
                <div class="row-title">
                    Active hotels
                </div>
                @foreach ($activeHotels as $activeHotel)
                    <div class="list-row">
                        <div>
                            {{ $activeHotel->name }}
                        </div>
                        <div>
                            <form action="{{ route('hotel.delete', ['hotel' => $activeHotel->id]) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="delete-button">Delete</button>
                            </form>
                            <a href="{{ route('hotel.edit.new', ['hotelName' => $hotel->name]) }}"
                                class="change-link">Edit</a>
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
