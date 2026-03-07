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
    Schema::table('students', function (Blueprint $table) {

        // SSC Details
        $table->string('ssc_medium')->nullable();
        $table->string('ssc_school')->nullable();
        $table->string('ssc_board')->nullable();

        // HSC Details
        $table->string('hsc_medium')->nullable();
        $table->string('hsc_school')->nullable();
        $table->string('hsc_board')->nullable();

        // Current Academic
        $table->string('current_program')->nullable();
        $table->string('current_semester')->nullable();
        $table->string('current_cgpa')->nullable();

        // Internship Status
        $table->boolean('is_interning')->default(false);
        $table->string('intern_position')->nullable();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            //
        });
    }
};
