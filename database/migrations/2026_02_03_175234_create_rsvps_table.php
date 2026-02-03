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
        Schema::create('rsvps', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('event_id')->nullable();
            $table->string('title', 10)->nullable();
            $table->string('name', 255);
            $table->string('org', 255)->nullable()->comment('Organization/Institution/University');
            $table->string('desig', 255)->nullable()->comment('Designation');
            $table->string('email', 255);
            $table->string('phone_country_code', 10)->nullable();
            $table->string('mob', 20)->nullable()->comment('Mobile/Contact Number');
            $table->string('city', 100)->nullable();
            $table->string('country', 100)->nullable();
            $table->text('participant')->nullable()->comment('Participant type or details');
            $table->text('comment')->nullable();
            $table->date('ddate')->nullable()->comment('Event Date');
            $table->string('ttime', 50)->nullable()->comment('Event Time');
            $table->string('event_identity', 255)->nullable()->comment('Event name/identity');
            $table->string('rsvp_location', 255)->nullable()->comment('RSVP Location');
            $table->unsignedBigInteger('association_id')->nullable();
            $table->string('association_name', 255)->nullable();
            $table->string('source_url', 500)->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->timestamps();

            // Indexes
            $table->index('event_id');
            $table->index('email');
            $table->index('association_id');
            $table->index('ddate');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rsvps');
    }
};
