@extends('layout.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
<link rel="stylesheet" href="{{ asset('css/rating.css') }}">
@endsection

@section('content')
@component('components.menu2')
@endcomponent

<div class="rating-update">
    <h3>口コミを編集</h3>

    <form class="rating-update__form" action="/rating/edit" method="POST" enctype="multipart/form-data">
        @csrf
        <input class="rating__form_input" type="hidden" name="rating_id" value="{{ $rating->id }}">
        <h4 class="rating__form_ttl">体験を評価してください</h4>
        <div class="rating__form_star">
            <input id="star01" type="radio" name="rating" value="5" {{ $rating->rating == 5 ? 'checked' : '' }}>
            <label for="star01">★</label>
            <input id="star02" type="radio" name="rating" value="4" {{ $rating->rating == 4 ? 'checked' : '' }}>
            <label for="star02">★</label>
            <input id="star03" type="radio" name="rating" value="3" {{ $rating->rating == 3 ? 'checked' : '' }}>
            <label for="star03">★</label>
            <input id="star04" type="radio" name="rating" value="2" {{ $rating->rating == 2 ? 'checked' : '' }}>
            <label for="star04">★</label>
            <input id="star05" type="radio" name="rating" value="1" {{ $rating->rating == 1 ? 'checked' : '' }}>
            <label for="star05">★</label>
        </div>
        <span class="error">@error('rating'){{ $message }}@enderror</span>

        <h4 class="rating__form_ttl">口コミを投稿</h4>
        <textarea class="rating-update__form_textarea" name="comment" rows="8" cols="50">{{ old('comment', $rating->comment) }}</textarea>
        <span class="error">@error('comment'){{ $message }}@enderror</span>

        <h4 class="rating__form_ttl">画像の追加</h4>
        <input class="rating-update__form_image" type="file" name="rating_image">
        <span class="error">@error('rating_image'){{ $message }}@enderror</span>
        @if($rating->rating_image)
        <p>現在の画像: <img src="{{ asset('storage/image/' . $rating->rating_image) }}" alt="口コミ画像" style="max-width: 150px;"></p>
        @endif

        <div class="rating__form_submit"></div>
        <button class="rating-update__submit-button" type="submit" class="btn btn-primary">口コミを投稿</button>
    </form>
</div>

@endsection