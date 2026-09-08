<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('course_files', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->nullable()->constrained('courses')->onDelete('cascade');
            $table->string('name');
            $table->string('file_path');
            $table->unsignedBigInteger('size')->default(0); // in bytes
            $table->string('mime_type')->nullable();
            $table->enum('scope', ['course', 'global'])->default('course'); // course = khusus kelas, global = semua kelas
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('course_files');
    }
};
