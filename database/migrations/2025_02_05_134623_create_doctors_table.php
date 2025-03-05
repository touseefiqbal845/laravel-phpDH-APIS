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
        Schema::create('doctors', function (Blueprint $table) {
            $table->id(); 
            $table->string('name');
            $table->string('career');
            $table->string('experience');
            $table->string('speciality');
            $table->json('stories')->nullable(); 
            $table->integer('rating')->default(0);
            $table->boolean('is_favourite')->default(false);
            $table->integer('reviews')->default(0);
            $table->decimal('hour_rate', 8, 2); 
            $table->json('time_slot'); 
            $table->json('details'); 
            $table->boolean('is_featured')->default(false);
            $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doctors');
    }
};
