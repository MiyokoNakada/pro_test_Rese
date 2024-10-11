@extends('layout.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/reviews.css') }}">
@endsection

@section('content')
@component('components.menu2')
@endcomponent
<div class="all-reviews">
    <a href="{{ url('/detail/' . $shop->id) }}" class="return"> &lt;</a>
    <h2>{{ $shop->name }}の全ての口コミ一覧</h2>


    <table class="all-reviews__table">
        <tr>
            <th>評価</th>
            <th>コメント</th>
            <th>画像</th>
            <th>投稿者</th>
        </tr>
        @foreach($reviews as $review)
        <tr>
            <td>
                @for ($i = 1; $i <= 5; $i++)
                    @if ($i <=$review->rating)
                    ★
                    @else
                    ☆
                    @endif
                    @endfor
            </td>
            <td>{{ $review->comment}}</td>
            <td><img src="{{ asset('storage/image/' . $review->rating_image) }}" alt="" width="200px"></td>
            <td>{{ $review->booking->user->name}}</td>
        </tr>
        @endforeach
    </table>

</div>

@endsection