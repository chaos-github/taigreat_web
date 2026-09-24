<?php

namespace App\Http\Requests\Console;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/** 工程實績分類。slug 編輯時略過自己那筆的 unique。 */
class CaseCategoryRequest extends FormRequest
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
        $category = $this->route('case_category');

        return [
            'name' => ['required', 'string', 'max:255'],
            'slug' => [
                'required',
                'string',
                'max:50',
                'alpha_dash',
                Rule::unique('case_categories', 'slug')->ignore($category),
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
