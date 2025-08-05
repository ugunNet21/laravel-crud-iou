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
        Schema::create('conversations', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('title');
            $table->enum('type', ['private', 'group', 'hotline']);
            $table->enum('status', ['open', 'processing', 'resolved', 'archived'])->default('open');
            $table->string('hotline_type', 50)->nullable();
            $table->enum('priority', ['low', 'medium', 'high', 'critical'])->default('medium');
            $table->string('case_number')->unique()->nullable();
            $table->text('description')->nullable();
            $table->boolean('is_private')->default(false);
            $table->string('service_type', 50)->nullable(); // DTKS/KPM etc
            $table->string('subject', 50)->nullable();
            $table->string('recipient_type', 50); // Back Office Kota / PIC
            $table->uuid('recipient_id'); 
            $table->uuid('created_by');
            $table->uuid('last_message_id')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('recipient_id')->references('id')->on('users');
            // $table->foreign('last_message_id')->references('id')->on('messages');
        });

        Schema::table('conversations', function (Blueprint $table) {
            $table->index(['type', 'status']);
            $table->index(['hotline_type', 'priority']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('conversations');
    }
};
