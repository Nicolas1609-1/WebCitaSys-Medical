<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Appointment;
use App\Models\ClinicalRecord;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DemoDataSeeder extends Seeder
{
    public function run(): void
    {
        $adminRole = Role::where('slug', 'admin')->first();
        $doctorRole = Role::where('slug', 'doctor')->first();
        $receptionistRole = Role::where('slug', 'receptionist')->first();
        $financialRole = Role::where('slug', 'financial')->first();
        $supportRole = Role::where('slug', 'support')->first();
        $patientRole = Role::where('slug', 'patient')->first();

        // 1. Usuario Administrador
        $userAdmin = User::create([
            'name' => 'Admin WebCitaSys',
            'email' => 'admin@webcitasys.com',
            'password' => Hash::make('password'),
            'role_id' => $adminRole?->id,
        ]);

        // 2. Médicos
        $userMendoza = User::create([
            'name' => 'Dr. Carlos Mendoza',
            'email' => 'carlos@webcitasys.com',
            'password' => Hash::make('password'),
            'role_id' => $doctorRole?->id,
        ]);

        $userLopez = User::create([
            'name' => 'Dra. Ana López',
            'email' => 'ana@webcitasys.com',
            'password' => Hash::make('password'),
            'role_id' => $doctorRole?->id,
        ]);

        $userGarcia = User::create([
            'name' => 'Dr. Roberto García',
            'email' => 'roberto@webcitasys.com',
            'password' => Hash::make('password'),
            'role_id' => $doctorRole?->id,
        ]);

        $userDoctor = User::create([
            'name' => 'Dr. Carlos Mendoza',
            'email' => 'doctor@webcitasys.com',
            'password' => Hash::make('password'),
            'role_id' => $doctorRole?->id,
        ]);

        $doctorMendoza = Doctor::create([
            'user_id' => $userMendoza->id,
            'first_name' => 'Carlos',
            'last_name' => 'Mendoza',
            'specialty' => 'Cardiología',
            'license_number' => 'COL-847293',
            'phone' => '+57 312 456 7890',
            'email' => 'carlos@webcitasys.com'
        ]);

        $userDoctor->update(['name' => 'Dr. Carlos Mendoza']);
        $doctorMendoza->update(['user_id' => $userDoctor->id]);

        $doctorLopez = Doctor::create([
            'user_id' => $userLopez->id,
            'first_name' => 'Ana',
            'last_name' => 'López',
            'specialty' => 'Medicina General',
            'license_number' => 'COL-938271',
            'phone' => '+57 315 987 6543',
            'email' => 'ana@webcitasys.com'
        ]);

        $doctorGarcia = Doctor::create([
            'user_id' => $userGarcia->id,
            'first_name' => 'Roberto',
            'last_name' => 'García',
            'specialty' => 'Pediatría',
            'license_number' => 'COL-123456',
            'phone' => '+57 300 111 2222',
            'email' => 'roberto@webcitasys.com'
        ]);

        // 3. Recepcionista
        User::create([
            'name' => 'Laura Martínez',
            'email' => 'recepcion@webcitasys.com',
            'password' => Hash::make('password'),
            'role_id' => $receptionistRole?->id,
        ]);

        // 4. Financiero
        User::create([
            'name' => 'Pedro Gómez',
            'email' => 'finanzas@webcitasys.com',
            'password' => Hash::make('password'),
            'role_id' => $financialRole?->id,
        ]);

        // 5. Soporte Técnico
        User::create([
            'name' => 'Soporte Técnico',
            'email' => 'soporte@webcitasys.com',
            'password' => Hash::make('password'),
            'role_id' => $supportRole?->id,
        ]);

        // ==================== PACIENTES ====================
        $patientJuan = Patient::create([
            'first_name' => 'Juan',
            'last_name' => 'Pérez González',
            'document_type' => 'CC',
            'document_number' => '12345678',
            'email' => 'juan.perez@gmail.com',
            'phone' => '3112223344',
            'birth_date' => '1985-04-12',
            'gender' => 'Masculino',
            'blood_type' => 'O+',
            'address' => 'Calle 100 #15-30, Bogotá'
        ]);

        $patientMaria = Patient::create([
            'first_name' => 'María',
            'last_name' => 'Rodríguez Silva',
            'document_type' => 'CC',
            'document_number' => '87654321',
            'email' => 'maria.rod@gmail.com',
            'phone' => '3125556677',
            'birth_date' => '1990-08-24',
            'gender' => 'Femenino',
            'blood_type' => 'A+',
            'address' => 'Carrera 7 #45-12, Bogotá'
        ]);

        $patientCarlos = Patient::create([
            'first_name' => 'Carlos',
            'last_name' => 'Ramírez Díaz',
            'document_type' => 'CC',
            'document_number' => '11223344',
            'email' => 'carlos.ramirez@hotmail.com',
            'phone' => '3209998877',
            'birth_date' => '1978-11-03',
            'gender' => 'Masculino',
            'blood_type' => 'O-',
            'address' => 'Calle 26 #68-40, Bogotá'
        ]);

        $patientAna = Patient::create([
            'first_name' => 'Ana',
            'last_name' => 'Martínez López',
            'document_type' => 'CC',
            'document_number' => '44332211',
            'email' => 'ana.martinez@gmail.com',
            'phone' => '3104445566',
            'birth_date' => '1995-02-15',
            'gender' => 'Femenino',
            'blood_type' => 'B+',
            'address' => 'Transversal 15 #120-45, Bogotá'
        ]);

        $patientPedro = Patient::create([
            'first_name' => 'Pedro',
            'last_name' => 'Sánchez Ruiz',
            'document_type' => 'CC',
            'document_number' => '55667788',
            'email' => 'pedro.sanchez@yahoo.com',
            'phone' => '3187778899',
            'birth_date' => '2000-06-30',
            'gender' => 'Masculino',
            'blood_type' => 'AB+',
            'address' => 'Avenida Suba #115-50, Bogotá'
        ]);

        // ==================== CITAS ====================
        Appointment::create([
            'patient_id' => $patientJuan->id,
            'doctor_id' => $doctorLopez->id,
            'appointment_date' => Carbon::today()->setHour(9)->setMinute(0),
            'reason' => 'Consulta de control general e hipertensión',
            'status' => 'Confirmada',
            'notes' => 'El paciente reporta dolor de cabeza leve ocasional.'
        ]);

        Appointment::create([
            'patient_id' => $patientMaria->id,
            'doctor_id' => $doctorGarcia->id,
            'appointment_date' => Carbon::today()->setHour(10)->setMinute(30),
            'reason' => 'Control de pediatría para su hijo menor',
            'status' => 'Pendiente',
            'notes' => 'Traer carné de vacunación actualizado.'
        ]);

        Appointment::create([
            'patient_id' => $patientCarlos->id,
            'doctor_id' => $doctorLopez->id,
            'appointment_date' => Carbon::today()->setHour(11)->setMinute(0),
            'reason' => 'Control post-operatorio leve',
            'status' => 'Completada',
            'notes' => 'Revisión de herida quirúrgica en antebrazo izquierdo.'
        ]);

        Appointment::create([
            'patient_id' => $patientPedro->id,
            'doctor_id' => $doctorMendoza->id,
            'appointment_date' => Carbon::today()->setHour(15)->setMinute(0),
            'reason' => 'Electrocardiograma de control',
            'status' => 'Confirmada',
            'notes' => 'Paciente con antecedentes de soplo cardíaco.'
        ]);

        // ==================== HISTORIAL CLÍNICO ====================
        ClinicalRecord::create([
            'patient_id' => $patientCarlos->id,
            'doctor_id' => $doctorLopez->id,
            'appointment_id' => 3,
            'record_date' => Carbon::today()->setHour(11)->setMinute(30),
            'weight' => '78',
            'height' => '174',
            'temperature' => '36.7',
            'blood_pressure' => '120/80',
            'heart_rate' => '74',
            'symptoms' => 'Refiere picazón leve alrededor de los puntos de sutura del antebrazo izquierdo.',
            'diagnosis' => 'Cicatrización normal en curso. Sin signos de infección local.',
            'treatment' => 'Limpieza diaria con suero fisiológico.',
            'prescription' => 'Acetaminofén 500mg - Tomar 1 tableta cada 8 horas por 3 días si hay dolor leve.'
        ]);

        ClinicalRecord::create([
            'patient_id' => $patientJuan->id,
            'doctor_id' => $doctorMendoza->id,
            'record_date' => Carbon::now()->subMonths(2),
            'weight' => '82',
            'height' => '178',
            'temperature' => '36.5',
            'blood_pressure' => '135/85',
            'heart_rate' => '80',
            'symptoms' => 'Cansancio fácil, mareos leves por las mañanas.',
            'diagnosis' => 'Hipertensión arterial estadio 1 en observación.',
            'treatment' => 'Reducir consumo de sal, realizar ejercicio cardiovascular regular.',
            'prescription' => 'Enalapril 10mg - Tomar 1 tableta cada 24 horas por 60 días.'
        ]);
    }
}
