@extends('layout.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/shop_detail.css') }}">
@endsection

@section('content')
@component('components.menu2')
@endcomponent

<div class="message">
    {{ session('message') }}
</div>

<div class="details">
    <div class="shop-detail">
        <div class="shop-detail__inner">
            <a href='/' class="return"> &lt;</a>
            <h2 class="shop-name">{{ $detail->name }}</h2>
            @if(app()->environment('local'))
            <img class="shop-img" src="{{ asset('storage/image/' . $detail->image) }}" alt="">
            @else
            <img class="shop-img" src="{{ Storage::disk('s3')->url('images/' . $detail->image) }}" alt="">
            @endif
            <p>#{{ $detail->area->name }} #{{ $detail->genre->name }}</p>
            <p>{{ $detail->description }}</p>
        </div>

        <div class="shop-rating">
            <div class="shop-rating__pending-rating">
                @if($pendingBooking)
                <button class="shop-rating__rating_button">
                    <a class="shop-rating__rating_link" href="{{ url('/rating?booking_id=' . $pendingBooking->id) }}">口コミを投稿する</a>
                </button>
                @endif
            </div>
            <div class="shop-rating__all-reviews">
                <a class="shop-rating__all-reviews_link" href="{{ url('/rating/all_reviews/' . $detail->id ) }}">全ての口コミ情報</a>
            </div>
            @if($userRating)
            <div class="shop-rating__latest-review">
                <div class="shop-rating__latest-review_buttons">
                    <a class="shop-rating__latest-review_edit" href="{{ url('/rating/edit/' . $userRating->id) }}">口コミを編集</a>
                    <form class="shop-rating__latest-review_form" action="{{ url('/rating/delete/' . $userRating->id) }}" method="POST" onsubmit="return confirm('本当に削除しますか？');">
                        @csrf
                        @method('DELETE')
                        <button class="shop-rating__latest-review_delete" type="submit">口コミを削除</button>
                    </form>
                </div>
                <p class="shop-rating__latest-review_stars">
                    @for ($i = 1; $i <= 5; $i++)
                        @if ($i <=$userRating->rating)
                        ★
                        @else
                        ☆
                        @endif
                        @endfor
                </p>
                <p class="shop-rating__latest-review_comment">{{ $userRating->comment }}</p>
                @if($userRating->rating_image)
                @if(app()->environment('local'))
                <img class="shop-rating__latest-review_image" src="{{ asset('storage/image/' . $userRating->rating_image) }}" alt="" width="200px">
                @else
                <img class="shop-rating__latest-review_image" src="{{ Storage::disk('s3')->url('images/' . $userRating->rating_image) }}" alt="" width="200px">
                @endif
                @endif
            </div>
            @endif
        </div>
    </div>

    <div class="booking">
        <div class="booking-card">
            <form class="booking-form" action="/done" method="post">
                @csrf
                <h2 class="booking-ttl">予約</h2>
                <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                <input type="hidden" name="shop_id" value="{{ $detail->id }}">
                <div class="form__error">
                    @error('date')
                    {{ $message }}
                    @enderror
                </div>
                <input class="booking-date" type="date" name="date" value="{{ old('date') }}">
                <div class="form__error">
                    @error('time')
                    {{ $message }}
                    @enderror
                </div>
                <select class="booking-time" name="time">
                    <option value="">選択してください</option>
                    @php
                    $start = new DateTime('10:00');
                    $end = new DateTime('24:00');
                    $interval = new DateInterval('PT30M');
                    @endphp
                    @for ($time = $start; $time < $end; $time->add($interval))
                        <option value="{{ $time->format('H:i') }}">{{ $time->format('H:i') }}</option>
                        @endfor
                </select>
                <div class="form__error">
                    @error('people_number')
                    {{ $message }}
                    @enderror
                </div>
                <select class="booking-number" name="people_number">
                    <option value=""></option>
                    @for ($i =1; $i <=10 ; $i++ ) <option value="{{ $i}}">{{$i}} </option>
                        @endfor
                </select>

                <div class="booking-confirm">
                    <table class="my_bookings__table">
                        <tr>
                            <th class="my_bookings__table-label">Shop</th>
                            <td class="my_bookings__table-item">{{ $detail->name }}</td>
                        </tr>
                        <tr>
                            <th class="my_bookings__table-label">Date</th>
                            <td class="my_bookings__table-item" id="display-date">0000-00-00</td>
                        </tr>
                        <tr>
                            <th class="my_bookings__table-label">Time</th>
                            <td class="my_bookings__table-item" id="display-time">00:00</td>
                        </tr>
                        <tr>
                            <th class="my_bookings__table-label">Number</th>
                            <td class="my_bookings__table-item" id="display-number">0人</td>
                        </tr>
                    </table>
                </div>
                <button class="booking-submit" type="submit">予約する</button>
            </form>
        </div>
    </div>
</div>

@endsection