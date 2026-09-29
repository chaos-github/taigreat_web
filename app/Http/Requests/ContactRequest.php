<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:100'],
            'company' => ['nullable', 'string', 'max:200'],
            'tel' => ['nullable', 'string', 'max:50'],
            'email' => ['required', 'email', 'max:255'],
            'subject' => ['required', 'string', 'max:200'],
            'content' => ['required', 'string'],
            'captcha' => ['required', 'string'],
            'agree' => ['accepted'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'name' => '姓名',
            'company' => '公司名稱',
            'tel' => '聯絡電話',
            'email' => '電子信箱',
            'subject' => '主旨',
            'content' => '留言訊息',
            'captcha' => '驗證碼',
            'agree' => '資料保護同意',
        ];
    }

    public function withValidator($validator): void
    {
        $validator->after(function ($validator): void {
            $expected = strtoupper((string) session('captcha_code'));
            $given = strtoupper((string) $this->input('captcha'));

            if ($expected === '' || $given !== $expected) {
                $validator->errors()->add('captcha', '驗證碼不正確');
            }
        });
    }
}
