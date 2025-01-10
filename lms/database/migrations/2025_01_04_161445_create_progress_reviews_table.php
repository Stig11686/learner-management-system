<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('progress_reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('learner_id')->constrained()->onDelete('cascade');
            $table->date('date');
            $table->text('notes')->nullable();
            $table->integer('duration')->nullable()->default(1);
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('progress_reviews');
    }
};