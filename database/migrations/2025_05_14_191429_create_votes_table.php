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
        Schema::create('votes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('candidate_id')->constrained()->onDelete('cascade');
            $table->foreignId('vote_group_id')->constrained()->onDelete('cascade');
            $table->string('voter_email')->nullable();
            $table->string('voter_phone')->nullable();
            $table->timestamps();
            $table->unique(['vote_group_id', 'voter_email']);
            $table->unique(['vote_group_id', 'voter_phone']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('votes');
    }
};
