<?php

namespace App\Http\Requests\Console;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class NewsRequest extends FormRequest
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
            'news_category_id' => ['required', 'exists:news_categories,id'],
            'title' => ['required', 'string', 'max:255'],
            'published_on' => ['required', 'date'],
            'image' => [Rule::requiredIf($this->isMethod('post')), 'nullable', 'image', 'max:4096'],
            'url' => ['nullable', 'url', 'max:255'],
            'sort' => ['required', 'integer', 'min:0'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'news_category_id' => '分類',
            'title' => '標題',
            'published_on' => '發布日期',
            'image' => '圖片',
            'url' => '外部連結',
            'sort' => '排序',
        ];
    }
}
