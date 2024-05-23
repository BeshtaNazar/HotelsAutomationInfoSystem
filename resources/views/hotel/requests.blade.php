@extends('components.layout')
@section('title', 'Manage Hotels Requests | Hotels Automation')
@section('css')
    <link rel="stylesheet" href="{{ asset('css/pages/hotel/requests.css') }}">
@endsection
@section('content')
    <div class="manage-hotels-requests-wrapper">
        <div class="container">
            <div class="page-title">
                <h2>Manage hotels requests</h2>
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
                                    {{ $inactiveHotel->building_number . ' ' . $inactiveHotel->street . ' ' . $inactiveHotel->city . ' ' . $inactiveHotel->postal_code . ' ' . $inactiveHotel->country }}
                                </div>
                                <div class="col">
                                    IBAN : {{ $inactiveHotel->iban }}
                                </div>
                            </div>
                            <div class="user-info">
                                <div class="row-title">User info:</div>
                                <div class="row-info">
                                    <div class="col">
                                        First name : {{ $inactiveHotel->user->first_name }}
                                    </div>
                                    <div class="col">
                                        Last name : {{ $inactiveHotel->user->last_name }}
                                    </div>
                                    <div class="col">
                                        Phone : {{ $inactiveHotel->user->phone }}
                                    </div>
                                    <div class="col">
                                        Email : {{ $inactiveHotel->user->email }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="hotel-actions">
                            <a href="{{ route('hotel.preview', ['hotelName' => $inactiveHotel->name]) }}"
                                class="preview-link">Preview</a>
                            <a href="{{ route('hotel.approve', ['hotelName' => $inactiveHotel->name]) }}"
                                class="change-link">Approve</a>
                            <form action="{{ route('hotel.delete', ['hotel' => $inactiveHotel->id]) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="delete-button">Decline</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="not-found-message">
                    There are no requests
                </div>
            @endif
        </div>
    </div>
    </div>
@endsection
@section('script')

@endsection
