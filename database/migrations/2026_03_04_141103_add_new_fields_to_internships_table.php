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
        Schema::table('internships', function (Blueprint $table) {

            if (!Schema::hasColumn('internships','duration')) {
                $table->string('duration')->nullable();
            }

            if (!Schema::hasColumn('internships','start_date')) {
                $table->date('start_date')->nullable();
            }

            if (!Schema::hasColumn('internships','end_date')) {
                $table->date('end_date')->nullable();
            }

            if (!Schema::hasColumn('internships','stipend')) {
                $table->string('stipend')->nullable();
            }

            if (!Schema::hasColumn('internships','address')) {
                $table->text('address')->nullable();
            }

            if (!Schema::hasColumn('internships','eligibility')) {
                $table->text('eligibility')->nullable();
            }

            if (!Schema::hasColumn('internships','application_deadline')) {
                $table->date('application_deadline')->nullable();
            }

            if (!Schema::hasColumn('internships','spots_available')) {
                $table->integer('spots_available')->nullable();
            }

            if (!Schema::hasColumn('internships','company_name')) {
                $table->string('company_name')->nullable();
            }

            if (!Schema::hasColumn('internships','company_technology')) {
                $table->string('company_technology')->nullable();
            }

            if (!Schema::hasColumn('internships','company_contact')) {
                $table->string('company_contact')->nullable();
            }

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('internships', function (Blueprint $table) {
            //
        });
    }
};