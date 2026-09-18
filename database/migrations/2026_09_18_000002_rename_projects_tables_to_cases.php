<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('projects') || Schema::hasTable('cases')) {
            return;
        }

        Schema::table('projects', function (Blueprint $table) {
            $table->dropForeign(['project_category_id']);
        });

        Schema::rename('project_categories', 'case_categories');
        Schema::rename('projects', 'cases');

        Schema::table('cases', function (Blueprint $table) {
            $table->renameColumn('project_category_id', 'case_category_id');
            $table->foreign('case_category_id')->references('id')->on('case_categories')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        if (! Schema::hasTable('cases') || Schema::hasTable('projects')) {
            return;
        }

        Schema::table('cases', function (Blueprint $table) {
            $table->dropForeign(['case_category_id']);
        });

        Schema::rename('case_categories', 'project_categories');
        Schema::rename('cases', 'projects');

        Schema::table('projects', function (Blueprint $table) {
            $table->renameColumn('case_category_id', 'project_category_id');
            $table->foreign('project_category_id')->references('id')->on('project_categories')->cascadeOnDelete();
        });
    }
};
