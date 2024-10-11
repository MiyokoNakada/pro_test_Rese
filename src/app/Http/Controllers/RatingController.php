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
    //評価用画面表示
    public function showRating(Request $request)
    {
        $booking = Booking::find($request->booking_id);

        $shop_id = $booking->shop_id;
        $areas = Area::all();
        $genres = Genre::all();
        $shop = Shop::with('area', 'genre')->find($shop_id);

        return view('rating', compact('booking','areas', 'genres', 'shop'));
    }

    //評価機能
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
        return redirect('/detail/' . $shop_id)->with('message', '評価を投稿しました');
    }
}
