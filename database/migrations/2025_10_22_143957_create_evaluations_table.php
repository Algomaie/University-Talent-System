<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('evaluations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('submission_id')->constrained()->onDelete('cascade');
            $table->foreignId('evaluator_id')->constrained('users')->onDelete('cascade');
            $table->integer('creativity_score')->nullable(); // درجة الإبداع (1-10)
            $table->integer('technical_score')->nullable(); // درجة التقنية (1-10)
            $table->integer('presentation_score')->nullable(); // درجة العرض (1-10)
            $table->integer('overall_score')->nullable(); // الدرجة الإجمالية
            $table->text('comments')->nullable();
            $table->boolean('is_nominated')->default(false);
            $table->text('nomination_reason')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('evaluations');
    }
};