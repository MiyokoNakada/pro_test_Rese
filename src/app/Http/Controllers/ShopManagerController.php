<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Manager;
use App\Models\Booking;
use App\Models\Shop;
use App\Models\Area;
use App\Models\Genre;
use Carbon\Carbon;
use App\Http\Requests\ShopRequest;
use App\Http\Requests\CsvShopRequest;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ShopsImport;
use Illuminate\Validation\ValidationException;


class ShopManagerController extends Controller
{
    //店舗代表者用ページ表示
    public function shopManager()
    {
        $user = Auth::user();
        $areas = Area::all();
        $genres = Genre::all();

        if ($user->role == '1') {
            return redirect('admin')->with('access-alert', '管理者は店舗情報にアクセスできません。');
        }

        $shop_info = Manager::with('user', 'shop', 'shop.area', 'shop.genre')
            ->where('user_id', $user->id)
            ->first();
        $bookings = [];
        if ($shop_info) {
            $bookings = Booking::with('user')
                ->where('shop_id', $shop_info->shop_id)
                ->orderBy('date', 'asc')
                ->orderBy('time', 'asc')
                ->get();
            foreach ($bookings as $booking) {
                $booking['formatted_time'] = Carbon::parse($booking->time)->format('H:i');
            }
        }
        return view('shop_manager', compact('shop_info', 'bookings', 'areas', 'genres'));
    }

    //店舗情報作成機能
    public function createShop(ShopRequest $request)
    {
        $user = Auth::user();
        $form = $request->all();
        $shop = Shop::create($form);

        if ($request->hasFile('image')) {
            $imageFile = $request->file('image');
            $imageName = $imageFile->getClientOriginalName();
            if (app()->environment('local')) {
                $imageFile->storeAs('public/image', $imageName);
                $form['image'] = $imageName;
            } else {
                Storage::disk('s3')->put('images/' . $imageName, file_get_contents($imageFile));
                Storage::disk('s3')->setVisibility('images/' . $imageName, 'public');
                $form['image'] = $imageName;
            }
            Shop::find($shop->id)->update($form);
        }
        $new_manager = new Manager;
        $new_manager->user_id = $user->id;
        $new_manager->shop_id = $shop->id;
        $new_manager->save();

        return redirect('shop_manager')->with('message', '店舗情報を作成しました');
    }

    // CSVインポート店舗情報作成機能
    public function importCsv(CsvShopRequest $request)
    {
        if ($request->hasFile('csv_file')) {
            try {
                Excel::import(new ShopsImport, $request->file('csv_file'));
                return redirect('shop_manager')->with('message', '店舗情報を作成しました');
            } catch (ValidationException $e) {
                return redirect('shop_manager')-> withErrors($e->validator)->withInput();
            } catch (\Exception $e) {
                return redirect('shop_manager')->with('error', 'インポート中にエラーが発生しました。');
            }
        }
        return redirect('shop_manager')->with('error', 'ファイルが選択されていません。');
    }

    //店舗情報編集画面表示
    public function showShopDetail(Request $request)
    {
        $user_id = Auth::user()->id;
        $shop_info = Manager::with('shop', 'shop.area', 'shop.genre')
            ->where('user_id', $user_id)
            ->first();
        $areas = Area::all();
        $genres = Genre::all();
        return view('shop_detail_update', compact('shop_info', 'areas', 'genres'));
    }

    //店舗情報更新機能
    public function updateShopDetail(ShopRequest $request)
    {
        $user_id = Auth::user()->id;
        $form = $request->all();
        unset($form['_token']);
        $shop_info = Manager::where('user_id', $user_id)->first();
        $shop_id = $shop_info->shop->id;

        if ($request->hasFile('image')) {
            $imageFile = $request->file('image');
            $imageName = $imageFile->getClientOriginalName();
            if (app()->environment('local')) {
                $imageFile->storeAs('public/image', $imageName);
                $form['image'] = $imageName;
            } else {
                Storage::disk('s3')->put('images/' . $imageName, file_get_contents($imageFile));
                Storage::disk('s3')->setVisibility('images/' . $imageName, 'public');
                $form['image'] = $imageName;
            }
        }

        Shop::find($shop_id)->update($form);

        return redirect('shop_manager')->with('message', '店舗情報を更新しました');;
    }

    //予約詳細画面表示
    public function bookingDetail(Request $request)
    {
        $booking = Booking::find($request->booking_id);
        $booking['formatted_time'] = Carbon::parse($booking->time)->format('H:i');

        return view('booking_detail', compact('booking'));
    }

    //来店確認
    public function storeVisit(Request $request)
    {
        $booking = Booking::find($request->id);
        $booking->visit_at = now();
        $booking->save();

        return redirect('shop_manager')->with('message', '来店情報を保存しました');
    }
}
