<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Ej: Administrador, Recepcionista...
            $table->string('slug')->unique(); // Ej: admin, receptionist...
            $table->text('description')->nullable();
            $table->json('permissions')->nullable(); // Permisos específicos del rol
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('roles');
    }
};
