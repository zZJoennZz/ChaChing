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
        Schema::create('member_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId("members_id")->constrained()->onDelete("cascade");
            $table->string("first_name"); // First name
            $table->string("middle_name")->nullable(); // Middle name
            $table->string("last_name"); // Last name
            $table->enum("gender", ["male", "female", "other"]); // Gender
            $table->date("birthday"); // Birthday
            $table->enum("civil_status", ["single", "married", "widowed", "divorced"])->nullable(); // Civil status
            $table->enum("house_status", ["owned", "living_with_relative", "rented"])->nullable(); // house status
            $table->string("name_on_check"); // Name on check
            $table->date("employment_date"); // Employment date
            $table->decimal("contributions_percentage", 5, 2); // Contributions percentage
            $table->string("tin_number"); // TIN number
            $table->string("phone_number_1")->nullable(); // Phone number 1
            $table->string("phone_number_2")->nullable(); // Phone number 2
            // $table->string("phone_number_3")->nullable(); // Phone number 3
            $table->string("address_1"); // Address 1
            $table->unsignedBigInteger("regions_id"); // Foreign key to regions
            $table->unsignedBigInteger("provinces_id"); // Foreign key to provinces
            $table->unsignedBigInteger("cities_id"); // Foreign key to cities
            $table->unsignedBigInteger("barangays_id"); // Foreign key to barangays
            $table->unsignedBigInteger("countries_id");
            $table->string("employee_number");
            $table->string("employee_status");
            $table->string("college_or_department");
            $table->string("photo");
            $table->string("signature");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('member_profiles');
    }
};
