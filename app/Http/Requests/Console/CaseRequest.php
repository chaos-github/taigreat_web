<?php

namespace App\Http\Requests\Console;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CaseRequest extends FormRequest
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
            'case_category_id' => ['required', 'exists:case_categories,id'],
            'title' => ['required', 'string', 'max:255'],
            'image' => [Rule::requiredIf($this->isMethod('post')), 'nullable', 'image', 'max:4096'],
            'is_featured' => ['sometimes', 'boolean'],
            'sort' => ['required', 'integer', 'min:0'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'case_category_id' => '分類',
            'title' => '標題',
            'image' => '圖片',
            'is_featured' => '首頁精選',
            'sort' => '排序',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'is_featured' => $this->boolean('is_featured'),
        ]);
    }
}
