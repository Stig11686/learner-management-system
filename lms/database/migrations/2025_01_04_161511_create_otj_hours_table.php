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
        Schema::create('otj_hours', function (Blueprint $table) {
            $table->id();
            $table->foreignId('learner_id')->constrained()->onDelete('cascade');
            $table->date('date'); 
            $table->enum('learning_type', ['session', 'tasks', 'coaching_mentoring', 'event_meetup_conference', 'shadowing', 'online_learning', 'cpd', 'research', 'workplace_review', ]);
            $table->integer('hours'); 
            $table->text('activity_description');
            $table->string('evidence_link')->nullable();
            $table->text('comments')->nullable();
            $table->enum('status', ['approved', 'pending', 'rejected']);
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('otj_hours');
    }
};
