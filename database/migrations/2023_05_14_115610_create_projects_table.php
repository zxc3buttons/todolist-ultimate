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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('owner_id');
            $table->string('name', 300);
            $table->text('description')->nullable();
            $table->unsignedBigInteger('status_id')->nullable();
            $table->timestamps();
            $table->timestamp('should_be_ended')->nullable();
            $table->foreign('owner_id')->references('id')->on('users')
                ->onDelete('cascade');
            $table->foreign('status_id')->references('id')->on('statuses')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
