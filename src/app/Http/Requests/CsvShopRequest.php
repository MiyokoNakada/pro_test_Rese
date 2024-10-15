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
            'csv_file' => 'required|file|mimes:csv,txt|max:2048',
        ];
    }

    //エラーメッセージの編集
    public function messages()
    {
        return [
            'csv_file.required' => 'ファイルを選択してください',
            'csv_file.file' => 'ファイルを選択してください',
            'csv_file.mimes' => '指定されたファイルがCSV形式ではありません',
            'csv_file.max' => 'CSVファイルは最大2MBまでです。',
        ];
    }
}
