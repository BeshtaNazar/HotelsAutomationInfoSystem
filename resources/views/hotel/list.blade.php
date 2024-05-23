@extends('components.layout')
@section('title', 'List Hotels | Hotels Automation')
@section('css')
    <link rel="stylesheet" href="{{ asset('css/pages/hotel/list.css') }}">
@endsection
@section('content')
    <div class="list-hotels-wrapper">
        <div class="container">
            @if (!empty(session('success')))
                <div role="alert" class="alert-message success-message">
                    {{ session('success') }}
                </div>
            @endif
            <div class="page-title">
                <h2>Continue listing or list new hotel</h2>
                <hr>
            </div>
            @foreach ($hotels as $hotel)
                <div class="list-row">
                    <div>
                        {{ $hotel->name }}
                    </div>
                    <div>
                        <form action="{{ route('hotel.delete', ['hotel' => $hotel->id]) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="delete-button">Delete</button>
                        </form>
                        <a href="{{ route('hotel.edit', ['hotelName' => $hotel->name]) }}" class="change-link">Continue</a>
                    </div>
                </div>
            @endforeach
            <div class="add-link">
                <a href="{{ route('hotel.create') }}">List new hotel</a>
            </div>
        </div>
    </div>
@endsection
@section('script')

@endsection
