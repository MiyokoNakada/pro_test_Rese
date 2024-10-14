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
        <textarea class="rating-update__form_textarea" name="comment" rows="8" cols="50" id="comment" placeholder="カジュアルな夜のお出かけにおすすめのスポット">{{ old('comment', $rating->comment) }}</textarea>
        <div class="rating__text-count">
            <span id="charCount">0 / 400(最高文字数)</span>
        </div>
        <span class="error">@error('comment'){{ $message }}@enderror</span>

        <h4 class="rating__form_ttl">画像の追加</h4>
        @if($rating->rating_image)
        @endif
        <div class="rating-update__form_image" id="inputFile">
            <input class="rating__image_input" type="file" name="rating_image" id="uploadFile" style="display: none;">
            <div class="rating__image_drop-area" id="dropArea">
                クリックして写真を追加<br><span>またはドロッグアンドドロップ</span>
                <p class="rating__image_selected-file" id="fileName" style="display:none;">選択されたファイル: <span id="selectedFileName"></span></p>
            </div>>
        </div>
        <p class="rating-update__current-image">現在の画像: <img src="{{ asset('storage/image/' . $rating->rating_image) }}" alt="口コミ画像" style="max-width: 150px;"></p>
        <span class="error">@error('rating_image'){{ $message }}@enderror</span>


        <div class="rating__form_submit"></div>
        <button class="rating-update__submit-button" type="submit" class="btn btn-primary">口コミを投稿</button>
    </form>
</div>

@endsection