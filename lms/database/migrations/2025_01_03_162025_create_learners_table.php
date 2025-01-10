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
        Schema::create('learners', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('cohort_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('employer')->nullable();
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->integer('target_otj_hours')->default(0);
            $table->enum('rag_rating', ['red', 'amber', 'green'])->default('green');
            $table->string('otjh_target')->nullable();
            $table->string('otjh_actual')->nullable();
            $table->string('drive_link')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('learners');
    }
};
