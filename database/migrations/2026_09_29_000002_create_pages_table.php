<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('title');
            $table->string('banner_image');
            $table->string('heading');
            $table->string('heading_en');
            $table->string('image');
            $table->string('eyebrow');
            $table->string('subtitle');
            $table->text('lead')->nullable();
            $table->text('body');
            $table->json('extra')->nullable();
            $table->timestamps();
        });

        $now = now();

        DB::table('pages')->insert([
            [
                'slug' => 'about',
                'title' => '關於我們 | 泰權興貿易',
                'banner_image' => 'upload/banner_page/2407261545110000001.jpg',
                'heading' => '關於我們',
                'heading_en' => 'ABOUT US',
                'image' => 'images/pic_4.jpg',
                'eyebrow' => 'Company',
                'subtitle' => '公司簡介',
                'lead' => '公司創立至今近四十年，持續在建築材料及創新工法上努力，引進海內外優質企業工藝技術並在台灣開發市場，針對台灣使用需求進行優化改良性質及成本控制。',
                'body' => '我們目前有七大主要產品系列，並皆已獲得市場的肯定。',
                'extra' => json_encode([
                    'mission_eyebrow' => 'Mission',
                    'mission_title' => '使命',
                    'mission_body' => '創新成就品質工程、工法推動建築發展',
                    'mission_en' => "【Innovation drives quality engineering】\n【Advanced techniques propel architectural progress】",
                ], JSON_UNESCAPED_UNICODE),
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'slug' => 'sustainability',
                'title' => '永續發展 | 泰權興貿易',
                'banner_image' => 'images/bg.jpg',
                'heading' => '永續發展',
                'heading_en' => 'SUSTAINABILITY',
                'image' => 'images/bg.jpg',
                'eyebrow' => 'Our commitment',
                'subtitle' => '用更好的材料與工法',
                'lead' => null,
                'body' => '泰權興以專業建構更美好的城市，並將環境友善、社會責任與綠色建築視為長期承諾，為下一代建構更永續的城市環境。',
                'extra' => json_encode([
                    'stats' => [
                        ['title' => '環境友善', 'text' => '降低碳排放、提升材料生命週期效率'],
                        ['title' => '社會責任', 'text' => '與在地工程夥伴共同提升施工安全與品質'],
                        ['title' => '綠色建築', 'text' => '導入低碳工法與綠建材，支援永續建築目標'],
                    ],
                ], JSON_UNESCAPED_UNICODE),
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('pages');
    }
};
