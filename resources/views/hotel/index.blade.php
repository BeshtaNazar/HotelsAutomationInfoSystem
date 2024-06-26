@extends('components.layout')
@section('title', $hotel->name . ' Hotel | Hotels Automation')
@section('css')
    <link rel="stylesheet" href="{{ asset('css/pages/hotel/index.css') }}">
@endsection
@section('content')
    <div class="hotel-wrapper">
        <div class="container">
            <div class="hotel-page">
                <div class="hotel-header">
                    <div class="hotel-title">
                        <h2>{{ $hotel->name }}</h2>
                        <span>{{ $hotel->building_number . ' ' . $hotel->street . ',' . $hotel->city }}</span>
                    </div>
                </div>
                <ul class="nav">
                    <li class="active"><a
                            href="{{ $isPreview ? route('hotel.preview', ['hotelName' => $hotel->name]) : route('hotel.show', ['hotelName' => $hotel->name]) }}">Overview</a>
                    </li>
                    <li><a
                            href="{{ $isPreview ? route('rooms.preview', ['hotelName' => $hotel->name]) : route('rooms.show', ['hotelName' => $hotel->name]) }}">Rooms</a>
                    </li>
                </ul>
                <div class="slider-container">
                    <div class="slider">
                        @foreach ($hotel->getMedia('hotels_images') as $media)
                            <img src="{{ $media->getUrl() }}" alt="{{ $media->name }}">
                        @endforeach
                    </div>
                    <button class="prev" onclick="prevSlide()">❮</button>
                    <button class="next" onclick="nextSlide()">❯</button>
                </div>
                <div class="hotel-features">
                    <div class="section-title">Features</div>
                    <ul>
                        <li>Total rooms :
                            {{ $hotel->rooms()->where('status', App\Enums\RoomStatus::ACTIVE->value)->count() }}</li>
                        <li>Children are {{ $hotel->are_children_allowed == 0 ? ' not allowed' : 'allowed' }}</li>
                        <li>Pets are {{ $hotel->are_pets_allowed == 0 ? ' not allowed' : 'allowed' }}</li>
                    </ul>
                </div>
            </div>
            @if ($isPreview && $isAdmin)
                <div class="admin-actions">
                    <a href="{{ route('hotel.approve', ['hotelName' => $hotel->name]) }}" class="change-link">Approve</a>
                    <form class="decline-form" action="{{ route('hotel.delete', ['hotel' => $hotel->id]) }}"
                        method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="delete-button">Decline</button>
                    </form>
                </div>
            @endif
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ asset('js/hotel/index/slider.js') }}"></script>
@endsection
