<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('news_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->unsignedSmallInteger('sort')->default(0);
            $table->timestamps();
        });

        $now = now();
        $categoryIds = [];

        foreach ([
            ['latest', '最新消息', 1],
            ['event', '活動展覽', 2],
            ['media', '媒體報導', 3],
        ] as [$slug, $name, $sort]) {
            $categoryIds[$slug] = DB::table('news_categories')->insertGetId([
                'name' => $name,
                'slug' => $slug,
                'sort' => $sort,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        Schema::table('news', function (Blueprint $table) {
            $table->foreignId('news_category_id')->nullable()->after('id')->constrained()->cascadeOnDelete();
        });

        foreach (DB::table('news')->get(['id', 'category']) as $row) {
            DB::table('news')->where('id', $row->id)->update([
                'news_category_id' => $categoryIds[$row->category] ?? $categoryIds['latest'],
            ]);
        }

        Schema::table('news', function (Blueprint $table) {
            $table->dropColumn('category');
        });
    }

    public function down(): void
    {
        Schema::table('news', function (Blueprint $table) {
            $table->string('category')->nullable()->after('title');
        });

        $slugs = DB::table('news_categories')->pluck('slug', 'id');

        foreach (DB::table('news')->get(['id', 'news_category_id']) as $row) {
            DB::table('news')->where('id', $row->id)->update([
                'category' => $slugs[$row->news_category_id] ?? 'latest',
            ]);
        }

        Schema::table('news', function (Blueprint $table) {
            $table->dropConstrainedForeignId('news_category_id');
        });

        Schema::dropIfExists('news_categories');
    }
};
