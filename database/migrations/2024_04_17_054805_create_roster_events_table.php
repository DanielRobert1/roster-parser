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
        Schema::create('roster_events', function (Blueprint $table) {
            $table->id();
            $table->uuid()->unique();
            $table->string('event_type');
            $table->string('activity');
            $table->string('arrival_location')->nullable();    
            $table->string('destination_location')->nullable();
            $table->timestamp('check_in')->nullable();
            $table->timestamp('check_out')->nullable();
            $table->timestamp('departure')->nullable();
            $table->timestamp('arrival')->nullable();
            $table->timestamp('event_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('roster_events');
    }
};
