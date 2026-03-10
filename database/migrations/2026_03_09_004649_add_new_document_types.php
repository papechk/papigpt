<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Add new columns for contrat and note_officielle
        if (!Schema::hasColumn('documents', 'reference')) {
            Schema::table('documents', function (Blueprint $table) {
                $table->string('reference')->nullable();
                $table->string('objet')->nullable();
                $table->string('duree')->nullable();
            });
        }
    }

    public function down(): void
    {
        Schema::table('documents', function (Blueprint $table) {
            $table->dropColumn(['reference', 'objet', 'duree']);
        });
    }
};
