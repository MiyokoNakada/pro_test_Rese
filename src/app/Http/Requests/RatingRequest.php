<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RatingRequest extends FormRequest
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
            'rating' => 'required',
            'comment' => 'nullable| string | max:400',
            'rating_image' => 'nullable|mimes:jpeg,png|max:2048',
        ];
    }

    //エラーメッセージの編集
    public function messages()
    {
        return [
            'rating.required' => '評価を選択してください',
            'comment.string' => '文字列で入力してください',
            'comment.max' => '400字以下で入力してください',
            'rating_image.mimes' => '指定された拡張子(jpeg/png)ではありません',
            'rating_image.max' => 'ファイルサイズは2MB以内にしてください',
        ];
    }
}
