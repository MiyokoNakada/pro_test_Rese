<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CsvShopRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'csv_file' => 'required|file|mimes:csv',
            'name' => 'required|string|max:50',
            'area' => 'required|string|in:東京都,大阪府,福岡県',
            'genre' => 'required|string|in:寿司,焼肉,イタリアン,居酒屋,ラーメン',
            'description' => 'nullable|string|max:400',
            'image' => 'nullable|url',
        ];
    }

    //エラーメッセージの編集
    public function messages()
    {
        return [
            'csv_file.required' => 'ファイルを選択してください',
            'csv_file.file' => 'ファイルを選択してください',
            'csv_file.mines' => '指定されたファイルがCSV形式ではありません',
            'name.required' => '店名を入力してください',
            'name.string' => '文字列で入力してください',
            'name.max' => '50字以下で入力してください',
            'area.required' => '地域名が入力されていません',
            'area.in' => '地域は「東京都」「大阪府」「福岡県」のいずれかを指定してください',
            'genre.required' => 'ジャンルが入力されていません',
            'genre.in' => 'ジャンルは「寿司」「焼肉」「イタリアン」「居酒屋」「ラーメン」のいずれかを指定してください',
            'description.string' => '文字列で入力してください',
            'description.max' => '400字以下で入力してください',
            'image.url' => '画像のURLを指定してください',
        ];
    }
}
