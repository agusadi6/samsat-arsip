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
        Schema::create('folders', function (Blueprint $table) {
            $table->id();
            // Foreign key ke tabel users dengan cascade delete (jika user dihapus, foldernya ikut terhapus)
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('folder_name');
            $table->string('physical_path');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('folders');
    }
};
