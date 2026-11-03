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
            'content' => ['required', 'string', 'max:5000'],
            'captcha' => ['required', 'string', 'max:10'],
            'website' => ['prohibited'],
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
            $expected = strtoupper((string) session()->pull('captcha_code'));
            $given = $this->input('captcha');
            $given = is_string($given) ? strtoupper($given) : '';

            if ($expected === '' || ! hash_equals($expected, $given)) {
                $validator->errors()->add('captcha', '驗證碼不正確');
            }
        });
    }
}
