<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('templates', function (Blueprint $table) {
            $table->string('design')->default('classique')->after('category');
        });

        Schema::table('documents', function (Blueprint $table) {
            $table->string('design')->default('classique')->after('template_id');
        });
    }

    public function down(): void
    {
        Schema::table('templates', function (Blueprint $table) {
            $table->dropColumn('design');
        });
        Schema::table('documents', function (Blueprint $table) {
            $table->dropColumn('design');
        });
    }
};
