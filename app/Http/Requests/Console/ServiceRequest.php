<?php

namespace App\Http\Requests\Console;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ServiceRequest extends FormRequest
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
            'number' => ['required', 'string', 'max:10'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'image' => [Rule::requiredIf($this->isMethod('post')), 'nullable', 'image', 'max:4096'],
            'links' => ['nullable', 'array'],
            'links.*.url' => ['nullable', 'url', 'max:255'],
            'links.*.label' => ['nullable', 'string', 'max:50'],
            'sort' => ['required', 'integer', 'min:0'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'number' => '編號',
            'title' => '標題',
            'description' => '說明',
            'image' => '圖片',
            'links' => '相關連結',
            'links.*.url' => '連結網址',
            'links.*.label' => '連結文字',
            'sort' => '排序',
        ];
    }

    /**
     * @return list<array{url: string, label: string}>
     */
    public function sanitizedLinks(): array
    {
        return collect($this->input('links', []))
            ->map(fn (array $link): array => [
                'url' => trim((string) ($link['url'] ?? '')),
                'label' => trim((string) ($link['label'] ?? '')),
            ])
            ->filter(fn (array $link): bool => $link['url'] !== '' || $link['label'] !== '')
            ->values()
            ->all();
    }
}
