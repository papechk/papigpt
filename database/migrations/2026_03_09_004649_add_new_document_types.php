<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE documents MODIFY COLUMN type ENUM('letter','invoice_proforma','invoice_final','contrat','note_officielle','page_garde') NOT NULL");
        DB::statement("ALTER TABLE templates MODIFY COLUMN type ENUM('letter','invoice_proforma','invoice_final','contrat','note_officielle','page_garde') NOT NULL");

        // Add new columns for contrat and note_officielle
        if (!Schema::hasColumn('documents', 'reference')) {
            Schema::table('documents', function ($table) {
                $table->string('reference')->nullable()->after('type');
                $table->string('objet')->nullable()->after('reference');
                $table->string('duree')->nullable()->after('objet');
            });
        }
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE documents MODIFY COLUMN type ENUM('letter','invoice_proforma','invoice_final') NOT NULL");
        DB::statement("ALTER TABLE templates MODIFY COLUMN type ENUM('letter','invoice_proforma','invoice_final') NOT NULL");

        Schema::table('documents', function ($table) {
            $table->dropColumn(['reference', 'objet', 'duree']);
        });
    }
};
