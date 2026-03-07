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
    Schema::create('internships', function (Blueprint $table) {
        $table->id();

        $table->foreignId('company_id')->constrained()->onDelete('cascade');

        $table->string('title');
        $table->text('description');
        $table->string('required_skills');
        $table->string('duration');
        $table->date('start_date');
        $table->date('end_date');
        $table->string('stipend');
        $table->text('address');
        $table->text('eligibility');
        $table->date('application_deadline');
        $table->integer('spots_available');

        // Company snapshot (auto filled but editable)
        $table->string('company_name');
        $table->string('company_technology')->nullable();
        $table->string('company_contact')->nullable();

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('internships');
    }
};
