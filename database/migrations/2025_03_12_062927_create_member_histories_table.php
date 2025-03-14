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
        Schema::create('member_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId("members_id")->constrained()->onDelete("cascade");
            $table->string("visibility");
            $table->string("title");
            $table->string("notes");
            $table->longText("others");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('member_histories');
    }
};
