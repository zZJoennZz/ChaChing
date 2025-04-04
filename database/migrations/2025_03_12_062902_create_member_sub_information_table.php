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
        Schema::create('member_sub_information', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("members_id");
            $table->string("information_type");
            $table->longText("sub_information");
            $table->timestamps();
            $table->foreign("members_id")->references("id")->on("members");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('member_sub_information');
    }
};
