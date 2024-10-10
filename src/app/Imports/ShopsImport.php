<?php

namespace App\Imports;

use App\Models\Shop;
use App\Models\Manager;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ShopsImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        $areas = ['大阪府' => 1, '東京都' => 2, '福岡県' => 3];
        $genres = ['イタリアン' => 1, 'ラーメン' => 2, '居酒屋' => 3, '寿司' => 4, '焼肉' => 5];

        $area_id = $areas[$row['area']] ?? null;
        $genre_id = $genres[$row['genre']] ?? null;

        if (!$area_id || !$genre_id) {
            return null;
        }

        $shop = new Shop([
            'name' => $row['shop'],
            'area_id' => $area_id,
            'genre_id' => $genre_id,
            'description' => $row['description'],
            'image' => $row['image'],
        ]);
        $shop->save();

        $user = Auth::user();
        if ($user) {
            $new_manager = new Manager;
            $new_manager->user_id = $user->id;
            $new_manager->shop_id = $shop->id;
            $new_manager->save();
        }

        return $shop;
    }
}
