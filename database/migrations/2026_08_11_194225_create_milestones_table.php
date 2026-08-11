<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('milestones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_id')->constrained('freelance_jobs')->cascadeOnDelete();
            $table->foreignId('bid_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->text('description')->nullable();
            $table->decimal('amount', 10, 2);
            $table->timestamp('due_date')->nullable();
            $table->integer('order')->default(1);
            $table->enum('status', ['pending', 'in_progress', 'submitted', 'approved', 'revision'])->default('pending');
            $table->boolean('payment_released')->default(false);
            $table->timestamp('payment_released_at')->nullable();
            $table->text('submission_note')->nullable();
            $table->text('revision_note')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('milestones');
    }
};