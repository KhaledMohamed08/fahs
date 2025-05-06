<?php

use App\Models\Assessment;
use App\Models\User;
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
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Assessment::class)->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->enum('type', ['free_text', 'true_false', 'multiple_choice']);
            $table->text('title');
            $table->unsignedInteger('score')->default(10);
            $table->boolean('is_true')->nullable(); // only for true false questions.
            $table->json('options')->nullable(); // only for multi choice questions.
            $table->longText('text_answer_model')->nullable(); // only for free text questions.
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};
