<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {

            $table->id();
            $table->unsignedBigInteger('user_id');

            $table->string('name')->nullable();
            $table->string('gender')->nullable();
            $table->text('address')->nullable();
            $table->string('mobile')->nullable();
            $table->date('dob')->nullable();

            // SSC
            $table->double('ssc_percentage')->nullable();
            $table->string('ssc_medium')->nullable();
            $table->string('ssc_school')->nullable();
            $table->string('ssc_board')->nullable();

            // HSC
            $table->double('hsc_percentage')->nullable();
            $table->string('hsc_medium')->nullable();
            $table->string('hsc_school')->nullable();
            $table->string('hsc_board')->nullable();

            // Current Study
            $table->string('current_program')->nullable();
            $table->string('current_semester')->nullable();
            $table->string('current_cgpa')->nullable();

            // Internship
            $table->boolean('is_interning')->default(0);
            $table->string('intern_position')->nullable();

            // Skills & Extra
            $table->text('skills')->nullable();
            $table->text('certifications')->nullable();
            $table->text('seminars')->nullable();
            $table->text('achievements')->nullable();

            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

        });
    }

    public function down()
    {
        Schema::dropIfExists('students');
    }
};