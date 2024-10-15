@extends('layout.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/rating.css') }}">
@endsection

@section('content')
@component('components.menu2')
@endcomponent
<div class="all-reviews">
    <a href="{{ url('/detail/' . $shop->id) }}" class="return"> &lt;</a>
    <h2>{{ $shop->name }}の全ての口コミ一覧</h2>


    <table class="all-reviews__table">
        <tr class="all-reviews__ttl_row">
            <th class="all-reviews__table-stars">評価</th>
            <th class="all-reviews__table-comment">コメント</th>
            <th class="all-reviews__table-image">画像</th>
            <th class="all-reviews__table-user">投稿者</th>
            <th class="all-reviews__table-admin"></th>
        </tr>
        @foreach($reviews as $review)
        <tr class="all-reviews__table_row">
            <td class="all-reviews__table_stars">
                @for ($i = 1; $i <= 5; $i++)
                    @if ($i <=$review->rating)
                    ★
                    @else
                    ☆
                    @endif
                    @endfor
            </td>
            <td class="all-reviews__table-comment_td">{{ $review->comment}}</td>
            <td>
                @if(app()->environment('local'))
                <img src="{{ asset('storage/image/' . $review->rating_image) }}" alt="" width="200px">
                @else
                <img src="{{ Storage::disk('s3')->url('images/' . $review->rating_image) }}" alt="" width="200px">
                @endif
            </td>
            <td>{{ $review->booking->user->name}}</td>
            <td>
                @can('admin')
                <form action="/rating/all_reviews/admin_delete" method="POST" onsubmit="return confirm('本当に削除しますか？');">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" name="rating_id" value="{{$review->id}}">
                    <button class="all-reviews__admin-delete_button" type="submit" class="btn btn-danger">口コミ削除</button>
                </form>
                @endcan
            </td>
        </tr>
        @endforeach
    </table>

</div>

@endsection