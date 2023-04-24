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
        Schema::create('participant_types', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();

            $table->string('url');

            $table->float('template_width')->nullable();
            $table->float('template_height')->nullable();

            $table->unsignedBigInteger('event_id');

            $table->foreign('event_id')->references('id')->on('events')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps(); 


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('participant_types');
    }
};
