@extends('layout.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
<link rel="stylesheet" href="{{ asset('css/rating.css') }}">
@endsection

@section('content')
@component('components.menu2')
@endcomponent
<div class="rating">
    <div class="rating__inner-left">
        <div class="rating__inner-left_inner">
            <h3 class="rating__title">今回のご利用はいかがでしたか？</h3>

            <div class="shops">
                <div class="shops-cards">
                    @if(app()->environment('local'))
                    <img class="shops-cards__img" src="{{ asset('storage/image/' . $shop->image) }}" alt="">
                    @else
                    <img class="shops-cards__img" src="{{ Storage::disk('s3')->url('images/' . $shop->image) }}" alt="">
                    @endif
                    <div class="shops-cards__contents">
                        <h2>{{ $shop->name }}</h2>
                        <p>#{{ $shop->area->name }} #{{ $shop->genre->name }}</p>
                        <div class="shops-cards__button">
                            <a class="shops-cards__button-detail" href="{{ url('/detail/' . $shop->id) }}">詳しくみる</a>
                            <form class="shops-cards__favourite-form">
                                @if($shop->favourites->contains('user_id', Auth::id()))
                                <i class="shops-cards__favourite fa-solid fa-heart fa-2xl favourited" data-user-id="{{ Auth::user()->id }}" data-shop-id="{{ $shop->id }}"></i>
                                @else
                                <i class="shops-cards__favourite fa-solid fa-heart fa-2xl" data-user-id="{{ Auth::user()->id }}" data-shop-id="{{ $shop->id }}"></i>
                                @endif
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="rating__inner-right">
        <form class="rating__form" action="/rating" method="POST" enctype="multipart/form-data">
            @csrf
            <input class="rating__form_input" type="hidden" name="booking_id" value="{{ $booking->id }}">
            <h4 class="rating__form_ttl">体験を評価してください</h4>
            <div class="rating__form_star">
                <input id="star01" type="radio" name="rating" value="5"><label for="star01">★</label>
                <input id="star02" type="radio" name="rating" value="4"><label for="star02">★</label>
                <input id="star03" type="radio" name="rating" value="3"><label for="star03">★</label>
                <input id="star04" type="radio" name="rating" value="2"><label for="star04">★</label>
                <input id="star05" type="radio" name="rating" value="1"><label for="star05">★</label>
            </div>
            <span class="error">@error('rating'){{ $message }}@enderror</span>

            <h4 class="rating__form_ttl">口コミを投稿</h4>
            <textarea class="rating__form_textarea" name="comment" rows="8" cols="50">{{ old('comment') }}</textarea>
            <span class="error">@error('comment'){{ $message }}@enderror</span>

            <h4 class="rating__form_ttl">画像の追加</h4>
            <input class="rating__form_image" type="file" name="rating_image">
            <span class="error">@error('rating_image'){{ $message }}@enderror</span>

            <div class="rating__form_submit"></div>
            <button class="rating__table_submit-button" type="submit" class="btn btn-primary">口コミを投稿</button>
        </form>
    </div>
</div>
@endsection