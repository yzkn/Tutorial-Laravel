<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;

class SubItemRequest extends FormRequest
{
    private $subtitleMaxLength = 64;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        Log::debug(sprintf('rules() method:%s', $this->method()));

        if ($this->isMethod('post') || $this->isMethod('put')) {
            // 新規投稿/レコード全項目更新
            return [
                'subtitle' => "required|max:{$this->subtitleMaxLength}",
            ];
        } elseif ($this->isMethod('put')) {
            // 部分更新
            return [
                'subtitle' => "max:{$this->subtitleMaxLength}",
            ];
        } else {
            return [];
        }
    }

    /**
    * @return array
    */
    public function messages()
    {
        if ($this->isMethod('post') || $this->isMethod('put')) {
            return [
                'subtitle.required' => 'タイトルは必須です。',
                'subtitle.max' => 'タイトルには64文字まで入力できます。',
            ];
        } elseif ($this->isMethod('put')) {
            // 部分更新
            return [
                'subtitle.max' => 'タイトルには64文字まで入力できます。',
            ];
        } else {
            return [];
        }
    }
}
