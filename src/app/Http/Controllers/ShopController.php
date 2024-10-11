<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Area;
use App\Models\Genre;
use App\Models\Shop;
use App\Models\Booking;
use App\Models\Rating;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class ShopController extends Controller
{
    //飲食店一覧表示
    public function index()
    {
        $areas = Area::all();
        $genres = Genre::all();
        $shops = Shop::with('area', 'genre')->get();

        return view('index', compact('areas', 'genres', 'shops'));
    }

    //ソート機能
    public function sort(Request $request)
    {
        $sort = $request->input('sort');

        $shops = Shop::leftJoin('bookings', 'shops.id', '=', 'bookings.shop_id')
            ->leftJoin('ratings', 'bookings.id', '=', 'ratings.booking_id')
            ->select('shops.*', DB::raw('AVG(ratings.rating) as avg_rating'))
            ->groupBy('shops.id');

        if ($sort == 'high') {
            $shops->orderByRaw('AVG(ratings.rating) IS NULL')
                ->orderBy('avg_rating', 'desc');
        } elseif ($sort == 'low') {
            $shops->orderByRaw('AVG(ratings.rating) IS NULL')
                ->orderBy('avg_rating', 'asc');
        } else {
            $shops->inRandomOrder();
        }

        $areas = Area::all();
        $genres = Genre::all();
        $shops = $shops->with('area', 'genre')->get();
        return view('index', compact('areas', 'genres', 'shops', 'sort'));
    }

    //検索機能
    public function search(Request $request)
    {
        $areas = Area::all();
        $genres = Genre::all();
        $query = Shop::with('area', 'genre');

        if ($request->filled('keyword')) {
            $query->keywordSearch($request->input('keyword'));
        }
        if ($request->filled('area_id')) {
            $query->areaSearch($request->input('area_id'));
        }
        if ($request->filled('genre_id')) {
            $query->genreSearch($request->input('genre_id'));
        }
        $shops = $query->get();

        return view('index', compact('areas', 'genres', 'shops'));
    }

    //飲食店詳細表示
    public function detail($shop_id)
    {
        $user_id = Auth::user()->id;
        $detail = Shop::find($shop_id);

        $userBookings = Booking::where('user_id', $user_id)
            ->where('shop_id', $shop_id)
            ->get();

        $pendingBooking = $userBookings
            ->filter(function ($booking) {
                return !$booking->rating;
            })
            ->first();

        $bookingIds = $userBookings->pluck('id');
        $userRating = Rating::whereIn('booking_id', $bookingIds)
            ->latest()
            ->first();


        return view('shop_detail', compact('detail', 'pendingBooking', 'userRating'));
    }
}
