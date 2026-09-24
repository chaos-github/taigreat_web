<?php

namespace App\Http\Requests\Console;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class NewsCategoryRequest extends FormRequest
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
        $category = $this->route('news_category');

        return [
            'name' => ['required', 'string', 'max:255'],
            'slug' => [
                'required',
                'string',
                'max:50',
                'alpha_dash',
                Rule::unique('news_categories', 'slug')->ignore($category),
            ],
            'sort' => ['required', 'integer', 'min:0'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'name' => '名稱',
            'slug' => '網址代碼',
            'sort' => '排序',
        ];
    }
}
