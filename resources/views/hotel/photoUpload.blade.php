@extends('components.layout')
@section('title', 'Upload Hotel Photo | Hotels Automation')
@section('css')
    <link rel="stylesheet" href="{{ asset('css/pages/list-hotel.css') }}">
@endsection
@section('content')
    <div class="upload-photo-wrapper">
        <div class="container">
            <form id="uploadPhotoForm" action="{{ route('hotel.upload.photo.store', ['hotelName' => $hotelName]) }}"
                method="POST" autocomplete="off" enctype="multipart/form-data">
                @csrf
                @error('images')
                    <div role="alert" class="alert-message failure-message">
                        {{ $message }}
                    </div>
                @enderror
                <div class="page-title">
                    <h2>Upload photo</h2>
                    <hr>
                </div>
                <div class="form-row">
                    <p>Upload 5 photos of your hotel, first photo is main</p>
                </div>
                <div class="form-row">
                    <input type="file" id="images" name="images[]" multiple accept="image/jpeg, image/png, image/jpg">
                </div>
                <div class="form-row list-hotel-submit-button">
                    <button class="submit-button" type="submit">Submit</button>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('script')
@endsection
