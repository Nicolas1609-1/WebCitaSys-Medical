<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Appointment;
use App\Models\ClinicalRecord;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Crear Usuarios para los Médicos
        $userMendoza = User::create([
            'name' => 'Dr. Carlos Mendoza',
            'email' => 'carlos@webcitasys.com',
            'password' => Hash::make('password'),
        ]);

        $userLopez = User::create([
            'name' => 'Dra. Ana López',
            'email' => 'ana@webcitasys.com',
            'password' => Hash::make('password'),
        ]);

        $userGarcia = User::create([
            'name' => 'Dr. Roberto García',
            'email' => 'roberto@webcitasys.com',
            'password' => Hash::make('password'),
        ]);

        // Usuario genérico para pruebas rápidas
        $userDoctor = User::create([
            'name' => 'Dr. Carlos Mendoza',
            'email' => 'doctor@webcitasys.com',
            'password' => Hash::make('password'),
        ]);

        // 2. Crear los Doctores vinculados
        $doctorMendoza = Doctor::create([
            'user_id' => $userMendoza->id,
            'first_name' => 'Carlos',
            'last_name' => 'Mendoza',
            'specialty' => 'Cardiología',
            'license_number' => 'COL-847293',
            'phone' => '+57 312 456 7890',
            'email' => 'carlos@webcitasys.com'
        ]);

        // También vinculamos el de prueba a Mendoza
        $userDoctor->update(['name' => 'Dr. Carlos Mendoza']);
        // vinculación del doctor de prueba
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

        // 3. Crear Pacientes
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

        // 4. Crear Citas de Prueba
        // Cita 1: Juan Pérez con Dra. Ana López (09:00 hoy, Confirmada)
        $appointment1 = Appointment::create([
            'patient_id' => $patientJuan->id,
            'doctor_id' => $doctorLopez->id,
            'appointment_date' => Carbon::today()->setHour(9)->setMinute(0),
            'reason' => 'Consulta de control general e hipertensión',
            'status' => 'Confirmada',
            'notes' => 'El paciente reporta dolor de cabeza leve ocasional.'
        ]);

        // Cita 2: María Rodríguez con Dr. Roberto García (10:30 hoy, Pendiente)
        $appointment2 = Appointment::create([
            'patient_id' => $patientMaria->id,
            'doctor_id' => $doctorGarcia->id,
            'appointment_date' => Carbon::today()->setHour(10)->setMinute(30),
            'reason' => 'Control de pediatría para su hijo menor',
            'status' => 'Pendiente',
            'notes' => 'Traer carné de vacunación actualizado.'
        ]);

        // Cita 3: Carlos Ramírez con Dra. Ana López (11:00 hoy, Completada)
        $appointment3 = Appointment::create([
            'patient_id' => $patientCarlos->id,
            'doctor_id' => $doctorLopez->id,
            'appointment_date' => Carbon::today()->setHour(11)->setMinute(0),
            'reason' => 'Control post-operatorio leve',
            'status' => 'Completada',
            'notes' => 'Revisión de herida quirúrgica en antebrazo izquierdo.'
        ]);

        // Cita 4: Pedro Sánchez con Dr. Carlos Mendoza (15:00 hoy, Confirmada)
        $appointment4 = Appointment::create([
            'patient_id' => $patientPedro->id,
            'doctor_id' => $doctorMendoza->id,
            'appointment_date' => Carbon::today()->setHour(15)->setMinute(0),
            'reason' => 'Electrocardiograma de control',
            'status' => 'Confirmada',
            'notes' => 'Paciente con antecedentes de soplo cardíaco.'
        ]);

        // 5. Crear Historial Clínico Inicial (Registrar Atención)
        // Registrar atención para la cita completada de Carlos Ramírez
        ClinicalRecord::create([
            'patient_id' => $patientCarlos->id,
            'doctor_id' => $doctorLopez->id,
            'appointment_id' => $appointment3->id,
            'record_date' => Carbon::today()->setHour(11)->setMinute(30),
            'weight' => '78',
            'height' => '174',
            'temperature' => '36.7',
            'blood_pressure' => '120/80',
            'heart_rate' => '74',
            'symptoms' => 'Refiere picazón leve alrededor de los puntos de sutura del antebrazo izquierdo. Sin signos de inflamación grave o pus.',
            'diagnosis' => 'Cicatrización normal en curso. Sin signos de infección local.',
            'treatment' => 'Limpieza diaria con suero fisiológico. No aplicar cremas o ungüentos sin autorización.',
            'prescription' => '1. Acetaminofén 500mg - Tomar 1 tableta cada 8 horas por 3 días si hay dolor leve.\n2. Gasas estériles - 1 paquete diario para protección.'
        ]);

        // Un registro clínico antiguo para Juan Pérez (para que tenga historial previo)
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
            'treatment' => 'Recomendaciones dietéticas: Reducir consumo de sal, realizar ejercicio cardiovascular regular (caminar 30 min diarios).',
            'prescription' => '1. Enalapril 10mg - Tomar 1 tableta cada 24 horas (en ayunas) por 60 días.\n2. Control diario de presión arterial anotado en bitácora.'
        ]);
    }
}
