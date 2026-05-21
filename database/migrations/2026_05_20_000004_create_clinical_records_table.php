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
        Schema::create('clinical_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained('patients')->onDelete('cascade');
            $table->foreignId('doctor_id')->constrained('doctors')->onDelete('cascade');
            $table->foreignId('appointment_id')->nullable()->constrained('appointments')->onDelete('set null');
            $table->dateTime('record_date');
            $table->string('weight')->nullable(); // en kg (ej. "70")
            $table->string('height')->nullable(); // en cm (ej. "175")
            $table->string('temperature')->nullable(); // en °C (ej. "36.5")
            $table->string('blood_pressure')->nullable(); // ej. "120/80"
            $table->string('heart_rate')->nullable(); // ej. "72"
            $table->text('symptoms');
            $table->text('diagnosis');
            $table->text('treatment')->nullable();
            $table->text('prescription')->nullable(); // Receta médica
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clinical_records');
    }
};
