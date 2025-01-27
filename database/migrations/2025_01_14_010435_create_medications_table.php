<?php

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
        Schema::create('medications', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class);
            $table->string('name');
            $table->string('dosage');
            $table->string('frequency');
            $table->string('medicationType');
            $table->date('startDate');
            $table->date('endDate');
            $table->text('instructions');
            $table->boolean('requiresFasting')->nullable();
            $table->json('schedule');
            $table->enum('status', ['active', 'inactive', 'completed']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medications');
    }
};
