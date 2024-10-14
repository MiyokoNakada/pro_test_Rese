<?php

namespace App\Http\Controllers;

use App\Http\Requests\RatingRequest;
use App\Models\Area;
use App\Models\Genre;
use App\Models\Shop;
use App\Models\Rating;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class RatingController extends Controller
{
    //口コミ投稿用画面表示
    public function showRating(Request $request)
    {
        $booking = Booking::find($request->booking_id);

        $shop_id = $booking->shop_id;
        $areas = Area::all();
        $genres = Genre::all();
        $shop = Shop::with('area', 'genre')->find($shop_id);

        return view('rating', compact('booking', 'areas', 'genres', 'shop'));
    }

    //口コミ投稿機能
    public function rating(RatingRequest $request)
    {
        $form = $request->all();
        $rating = new Rating($form);

        if ($request->hasFile('rating_image')) {
            $imageFile = $request->file('rating_image');
            $imageName = $imageFile->getClientOriginalName();
            if (app()->environment('local')) {
                $imageFile->storeAs('public/image', $imageName);
            } else {
                Storage::disk('s3')->put('images/' . $imageName, file_get_contents($imageFile));
                Storage::disk('s3')->setVisibility('images/' . $imageName, 'public');
            }
            $rating->rating_image = $imageName;
        }

        $rating->save();

        $shop_id = Booking::find($request->booking_id)->shop_id;
        return redirect('/detail/' . $shop_id)->with('message', '口コミを投稿しました');
    }

    //口コミ編集画面表示
    public function editRating($rating_id)
    {
        $rating = Rating::with('booking')
            ->findOrFail($rating_id);

        return view('rating_update', compact('rating'));
    }

    //口コミ編集機能
    public function updateRating(RatingRequest $request)
    {
        $rating = Rating::with('booking')->findOrFail($request->rating_id);
        $rating->rating = $request->rating;
        $rating->comment = $request->comment;

        if ($request->hasFile('rating_image')) {
            $imageFile = $request->file('rating_image');
            $imageName = $imageFile->getClientOriginalName();
            if (app()->environment('local')) {
                $imageFile->storeAs('public/image', $imageName);
            } else {
                Storage::disk('s3')->put('images/' . $imageName, file_get_contents($imageFile));
                Storage::disk('s3')->setVisibility('images/' . $imageName, 'public');
            }
            $rating->rating_image = $imageName;
        }
        if ($request->has('remove')) {
            if ($rating->rating_image) {
                if (app()->environment('local')) {
                    Storage::delete('public/image/' . $rating->rating_image);
                } else {
                    Storage::disk('s3')->delete('images/' . $rating->rating_image);
                }
                $rating->rating_image = null;
            }
        }

        $rating->save();

        $shop_id = Booking::find($rating->booking_id)->shop_id;
        return redirect('/detail/' . $shop_id)->with('message', '口コミを更新しました');
    }


    //口コミ削除機能
    public function deleteRating($rating_id)
    {
        $rating = Rating::findOrFail($rating_id);
        $shop_id = Booking::find($rating->booking_id)->shop_id;

        $rating->delete();

        return redirect('/detail/' . $shop_id)->with('message', '１件の口コミを削除しました');
    }

    //口コミ一覧ページ表示
    public function allReviews($shop_id)
    {
        $shop = Shop::find($shop_id);
        $bookingIds = Booking::where('shop_id', $shop_id)->pluck('id');
        $reviews = Rating::with('booking')
            ->whereIn('booking_id', $bookingIds)
            ->get();

        return view('reviews', compact('shop', 'reviews'));
    }

    //管理者用口コミ削除機能
    public function deleteReviews(Request $request){
        $rating = Rating::findOrFail($request->rating_id);
        $shop_id = Booking::find($rating->booking_id)->shop_id;

        $rating->delete();

        return redirect('/rating/all_reviews/' . $shop_id)->with('message', '１件の口コミを削除しました');
    }
}
