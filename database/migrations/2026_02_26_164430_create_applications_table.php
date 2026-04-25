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
        Schema::create('applications', function (Blueprint $table) {

            $table->id();

            $table->foreignId('student_id')
                  ->constrained()
                  ->onDelete('cascade');

            $table->foreignId('internship_id')
                  ->constrained()
                  ->onDelete('cascade');

            $table->string('status')
                  ->default('pending'); // pending, selected, rejected

            // prevent duplicate apply
            $table->unique(['student_id', 'internship_id']);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};