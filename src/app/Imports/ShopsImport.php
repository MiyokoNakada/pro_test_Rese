<?php

namespace App\Imports;

use App\Models\Shop;
use App\Models\Manager;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

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

        $imageUrl = $row['image'];
        $imageName = $this->downloadImage($imageUrl);

        $shop = new Shop([
            'name' => $row['shop'],
            'area_id' => $area_id,
            'genre_id' => $genre_id,
            'description' => $row['description'],
            'image' => $imageName,
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

    //画像をダウンロードして保存するメソッド
    private function downloadImage($url)
    {
        $response = Http::withOptions(['stream' => true])->get($url);
        if ($response->successful()) {
            $mimeType = $response->header('Content-Type');

            $extension = null;
            $mimeTypes = [
                'image/jpeg' => 'jpg',
                'image/png' => 'png',
            ];
            if (isset($mimeTypes[$mimeType])) {
                $extension = $mimeTypes[$mimeType];
            }
            if (!$extension) {
                return null;
            }
            $imageName = Str::random(20) . '.' . $extension;
            $stream = $response->getBody()->getContents();
            Storage::put('public/image/' . $imageName, $stream);

            return $imageName;
        }

        return null;
    }
}
