<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('documents', function (Blueprint $table) {
            $table->string('titre_destinataire')->nullable()->after('client_name');
            $table->string('telephone_destinataire')->nullable()->after('client_address');
        });
    }

    public function down(): void
    {
        Schema::table('documents', function (Blueprint $table) {
            $table->dropColumn(['titre_destinataire', 'telephone_destinataire']);
        });
    }
};
