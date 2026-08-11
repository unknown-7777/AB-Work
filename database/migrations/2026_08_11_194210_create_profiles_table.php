<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('title')->nullable();
            $table->text('bio')->nullable();
            $table->string('location')->nullable();
            $table->string('website')->nullable();
            $table->decimal('hourly_rate', 8, 2)->nullable();
            $table->json('skills')->nullable();
            $table->json('languages')->nullable();
            $table->enum('availability', ['available', 'busy', 'unavailable'])->default('available');
            $table->integer('total_jobs_completed')->default(0);
            $table->decimal('avg_rating', 3, 2)->default(0.00);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};