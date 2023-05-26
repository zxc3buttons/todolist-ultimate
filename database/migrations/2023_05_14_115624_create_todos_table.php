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
        Schema::create('todos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('project_id');
            $table->unsignedBigInteger('task_id');
            $table->string('name', 300);
            $table->text('description')->nullable();
            $table->boolean('is_done')->default(false);
            $table->timestamps();
            $table->timestamp('should_be_ended')->nullable();
            $table->foreign('project_id')->references('id')->on('projects')
                ->onDelete('cascade');
            $table->foreign('task_id')->references('id')->on('tasks')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('todos');
    }
};
