<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasTable('poster_registration_demos') && Schema::hasColumn('poster_registration_demos', 'gst_required')) {
            DB::statement("ALTER TABLE poster_registration_demos MODIFY COLUMN gst_required ENUM('0', '1') DEFAULT '0'");
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('poster_registration_demos') && Schema::hasColumn('poster_registration_demos', 'gst_required')) {
            DB::statement("ALTER TABLE poster_registration_demos MODIFY COLUMN gst_required ENUM('0', '1') DEFAULT '1'");
        }
    }
};
