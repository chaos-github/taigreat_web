<?php

namespace App\Http\Requests\Console;

use Illuminate\Foundation\Http\FormRequest;

/** 關於我們 / 永續發展頁面表單。圖片可不換。 */
class PageRequest extends FormRequest
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
        $rules = [
            'heading' => ['required', 'string', 'max:100'],
            'heading_en' => ['required', 'string', 'max:100'],
            'banner_image' => ['nullable', 'image', 'max:4096'],
            'image' => ['nullable', 'image', 'max:4096'],
            'eyebrow' => ['required', 'string', 'max:100'],
            'subtitle' => ['required', 'string', 'max:100'],
            'body' => ['required', 'string'],
        ];

        if ($this->slug() === 'about') {
            $rules['lead'] = ['required', 'string'];
            $rules['mission_eyebrow'] = ['required', 'string', 'max:100'];
            $rules['mission_title'] = ['required', 'string', 'max:100'];
            $rules['mission_body'] = ['required', 'string'];
            $rules['mission_en'] = ['required', 'string'];
        } else {
            $rules['lead'] = ['nullable', 'string'];
            $rules['stats'] = ['required', 'array', 'size:3'];
            $rules['stats.*.title'] = ['required', 'string', 'max:50'];
            $rules['stats.*.text'] = ['required', 'string', 'max:200'];
        }

        return $rules;
    }

    /**
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'heading' => '頁面標題',
            'heading_en' => '英文標題',
            'banner_image' => '橫幅圖片',
            'image' => '內文圖片',
            'eyebrow' => '小標',
            'subtitle' => '區塊標題',
            'lead' => '引言',
            'body' => '內文',
            'mission_eyebrow' => '使命小標',
            'mission_title' => '使命標題',
            'mission_body' => '使命內文',
            'mission_en' => '使命英文',
            'stats' => '重點項目',
            'stats.*.title' => '重點標題',
            'stats.*.text' => '重點說明',
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public function extraPayload(): array
    {
        if ($this->slug() === 'about') {
            return [
                'mission_eyebrow' => $this->string('mission_eyebrow')->toString(),
                'mission_title' => $this->string('mission_title')->toString(),
                'mission_body' => $this->string('mission_body')->toString(),
                'mission_en' => $this->string('mission_en')->toString(),
            ];
        }

        return [
            'stats' => collect($this->input('stats', []))
                ->map(fn (array $stat): array => [
                    'title' => trim((string) ($stat['title'] ?? '')),
                    'text' => trim((string) ($stat['text'] ?? '')),
                ])
                ->values()
                ->all(),
        ];
    }

    private function slug(): string
    {
        return $this->routeIs('console.about.*') ? 'about' : 'sustainability';
    }
}
