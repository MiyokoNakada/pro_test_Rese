<?php

namespace App\Imports;

use App\Models\Shop;
use App\Models\Manager;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class ShopsImport implements ToModel, WithHeadingRow, WithValidation
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

    //画像をダウンロードして保存
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
            if (app()->environment('local')) {
                Storage::put('public/image/' . $imageName, $stream);
            } else {
                Storage::put('images/' . $imageName, $stream);
            }

            return $imageName;
        }

        return null;
    }

    // バリデーションルール
    public function rules(): array
    {
        return [
            '*.shop' => 'required|string|max:50',
            '*.area' => 'required|string|in:大阪府,東京都,福岡県',
            '*.genre' => 'required|string|in:イタリアン,ラーメン,居酒屋,寿司,焼肉',
            '*.description' => 'required|string|max:400',
            '*.image' => ['required', 'url', 'regex:/\.(jpg|jpeg|png)$/i'],
        ];
    }
    // バリデーションエラーメッセージ
    public function customValidationMessages()
    {
        return [
            '*.shop.required' => '店名を入力してください',
            '*.shop.string' => '文字で入力してください',
            '*.shop.max' => '50字以下で入力してください',
            '*.area.required' => '地域名を入力してください',
            '*.area.string' => '文字で入力してください',
            '*.area.in' => '地域名は「東京都」「大阪府」「福岡県」のいずれかを指定してください',
            '*.genre.required' => 'ジャンルを入力してください',
            '*.genre.string' => '文字で入力してください',
            '*.genre.in' => 'ジャンルは「寿司」「焼肉」「イタリアン」「居酒屋」「ラーメン」のいずれかを指定してください',
            '*.description.required' => '店舗詳細を入力してください',
            '*.description.string' => '文字で入力してください',
            '*.description.max' => '400字以下で入力してください',
            '*.image.required' => '店舗画像のURLを入力してください',
            '*.image.url' => '画像をURL形式で記載してください',
            '*.image.regex' => '画像の拡張子はJPEGまたはPNG形式のみ使用できます',
        ];
    }
}
