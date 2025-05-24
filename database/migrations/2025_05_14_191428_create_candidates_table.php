<?php

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
        Schema::create('candidates', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->foreignIdFor(Vote::class)->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->integer('votes_count')->default(0);
            $table->string('description')->nullable();
            $table->string('profession')->nullable();
            $table->string('university')->nullable();
            $table->string('theme')->nullable();
            $table->string('photo')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('candidates');
    }
};
