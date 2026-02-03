<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('poster_registration_demos', function (Blueprint $table) {
            // Add GST breakdown columns after gst_amount
            if (!Schema::hasColumn('poster_registration_demos', 'igst_rate')) {
                $table->decimal('igst_rate', 5, 2)->nullable()->after('gst_amount');
            }
            if (!Schema::hasColumn('poster_registration_demos', 'igst_amount')) {
                $table->decimal('igst_amount', 10, 2)->nullable()->after('igst_rate');
            }
            if (!Schema::hasColumn('poster_registration_demos', 'cgst_rate')) {
                $table->decimal('cgst_rate', 5, 2)->nullable()->after('igst_amount');
            }
            if (!Schema::hasColumn('poster_registration_demos', 'cgst_amount')) {
                $table->decimal('cgst_amount', 10, 2)->nullable()->after('cgst_rate');
            }
            if (!Schema::hasColumn('poster_registration_demos', 'sgst_rate')) {
                $table->decimal('sgst_rate', 5, 2)->nullable()->after('cgst_amount');
            }
            if (!Schema::hasColumn('poster_registration_demos', 'sgst_amount')) {
                $table->decimal('sgst_amount', 10, 2)->nullable()->after('sgst_rate');
            }
            if (!Schema::hasColumn('poster_registration_demos', 'processing_rate')) {
                $table->decimal('processing_rate', 5, 2)->nullable()->after('processing_fee');
            }
            
            // Add tin_no column if not exists
            if (!Schema::hasColumn('poster_registration_demos', 'tin_no')) {
                $table->string('tin_no')->nullable()->unique()->after('token');
            }
            
            // Add GST Invoice fields
            if (!Schema::hasColumn('poster_registration_demos', 'gst_required')) {
                $table->enum('gst_required', ['0', '1'])->default('0')->after('status');
            }
            if (!Schema::hasColumn('poster_registration_demos', 'gstin')) {
                $table->string('gstin', 15)->nullable()->after('gst_required');
            }
            if (!Schema::hasColumn('poster_registration_demos', 'gst_legal_name')) {
                $table->string('gst_legal_name', 255)->nullable()->after('gstin');
            }
            if (!Schema::hasColumn('poster_registration_demos', 'gst_address')) {
                $table->text('gst_address')->nullable()->after('gst_legal_name');
            }
            if (!Schema::hasColumn('poster_registration_demos', 'gst_state')) {
                $table->string('gst_state', 100)->nullable()->after('gst_address');
            }
            if (!Schema::hasColumn('poster_registration_demos', 'gst_country')) {
                $table->string('gst_country', 100)->default('India')->after('gst_state');
            }
            if (!Schema::hasColumn('poster_registration_demos', 'contact_name')) {
                $table->string('contact_name', 255)->nullable()->after('gst_country');
            }
            if (!Schema::hasColumn('poster_registration_demos', 'contact_email')) {
                $table->string('contact_email', 255)->nullable()->after('contact_name');
            }
            if (!Schema::hasColumn('poster_registration_demos', 'contact_phone')) {
                $table->string('contact_phone', 30)->nullable()->after('contact_email');
            }
            if (!Schema::hasColumn('poster_registration_demos', 'contact_phone_country_code')) {
                $table->string('contact_phone_country_code', 10)->default('+91')->after('contact_phone');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('poster_registration_demos', function (Blueprint $table) {
            $columns = [
                'igst_rate',
                'igst_amount',
                'cgst_rate',
                'cgst_amount',
                'sgst_rate',
                'sgst_amount',
                'processing_rate',
                'gst_required',
                'gstin',
                'gst_legal_name',
                'gst_address',
                'gst_state',
                'gst_country',
                'contact_name',
                'contact_email',
                'contact_phone',
                'contact_phone_country_code',
            ];
            
            foreach ($columns as $column) {
                if (Schema::hasColumn('poster_registration_demos', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
