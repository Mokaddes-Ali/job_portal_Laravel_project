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
        Schema::create('post_jobs', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
            $table->foreignId('job_type_id')->constrained('job_types')->onDelete('cascade');
            $table->string('job_nature');
            $table->integer('vacancy');
            $table->string('salary')->nullable();
            $table->string('location');
            $table->text('description');
            $table->text('benefits')->nullable();
            $table->text('responsibility')->nullable();
            $table->text('qualifications')->nullable();
            $table->string('keywords');
            $table->string('company_name');
            $table->string('company_location')->nullable();
            $table->string('website')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('post_jobs');
    }
};
