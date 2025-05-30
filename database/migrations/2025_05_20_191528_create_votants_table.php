<?php

use App\Models\Candidate;
use App\Models\Vote;
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
        Schema::create('votants', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Candidate::class)->nullable()->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignIdFor(Vote::class)->nullable()->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->string('identity');
            $table->boolean('is_voted')->default(false);
            $table->unique(['vote_id', 'identity', 'candidate_id']);
            $table->string('ip_address')->nullable();
            $table->string('user_agent')->nullable();
            $table->string('country')->nullable();
            $table->integer('otp')->nullable();
            $table->boolean('is_verified')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('votants');
    }
};
