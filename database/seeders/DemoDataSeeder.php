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

        // ==================== DATOS ADICIONALES DR. MENDOZA (doctor@webcitasys.com) ====================
        // Citas adicionales hoy
        Appointment::create([
            'patient_id' => $patientJuan->id,
            'doctor_id' => $doctorMendoza->id,
            'appointment_date' => Carbon::today()->setHour(8)->setMinute(0),
            'reason' => 'Control de hipertensión mensual',
            'status' => 'Completada',
            'notes' => 'Paciente estable. Presión 120/80.'
        ]);

        Appointment::create([
            'patient_id' => $patientMaria->id,
            'doctor_id' => $doctorMendoza->id,
            'appointment_date' => Carbon::today()->setHour(9)->setMinute(30),
            'reason' => 'Dolor torácico recurrente',
            'status' => 'Pendiente',
            'notes' => 'Paciente refiere dolor en pecho desde hace 2 semanas.'
        ]);

        Appointment::create([
            'patient_id' => $patientAna->id,
            'doctor_id' => $doctorMendoza->id,
            'appointment_date' => Carbon::today()->setHour(11)->setMinute(0),
            'reason' => 'Control de arritmia cardiaca',
            'status' => 'Confirmada',
            'notes' => 'Traer resultados de holter.'
        ]);

        // Citas próximos días
        Appointment::create([
            'patient_id' => $patientJuan->id,
            'doctor_id' => $doctorMendoza->id,
            'appointment_date' => Carbon::tomorrow()->setHour(10)->setMinute(0),
            'reason' => 'Consulta de seguimiento cardiovascular',
            'status' => 'Confirmada',
            'notes' => 'Evaluar resultados de exámenes de sangre.'
        ]);

        Appointment::create([
            'patient_id' => $patientCarlos->id,
            'doctor_id' => $doctorMendoza->id,
            'appointment_date' => Carbon::tomorrow()->setHour(14)->setMinute(30),
            'reason' => 'Evaluación pre-operatoria',
            'status' => 'Pendiente',
            'notes' => 'Paciente será sometido a cirugía de rodilla.'
        ]);

        Appointment::create([
            'patient_id' => $patientMaria->id,
            'doctor_id' => $doctorMendoza->id,
            'appointment_date' => Carbon::today()->addDays(2)->setHour(9)->setMinute(0),
            'reason' => 'Resultados de ecocardiograma',
            'status' => 'Confirmada',
            'notes' => 'Entregar y explicar resultados.'
        ]);

        Appointment::create([
            'patient_id' => $patientAna->id,
            'doctor_id' => $doctorMendoza->id,
            'appointment_date' => Carbon::today()->addDays(3)->setHour(11)->setMinute(30),
            'reason' => 'Control de medicación anticoagulante',
            'status' => 'Pendiente',
            'notes' => 'Revisar INR y ajustar dosis.'
        ]);

        Appointment::create([
            'patient_id' => $patientPedro->id,
            'doctor_id' => $doctorMendoza->id,
            'appointment_date' => Carbon::today()->addDays(5)->setHour(8)->setMinute(30),
            'reason' => 'Control cardiológico rutinario',
            'status' => 'Confirmada',
            'notes' => 'Ayuno de 8 horas requerido.'
        ]);

        // ==================== REGISTROS CLÍNICOS ADICIONALES DR. MENDOZA ====================
        ClinicalRecord::create([
            'patient_id' => $patientJuan->id,
            'doctor_id' => $doctorMendoza->id,
            'record_date' => Carbon::today()->setHour(8)->setMinute(30),
            'weight' => '83',
            'height' => '178',
            'temperature' => '36.5',
            'blood_pressure' => '118/78',
            'heart_rate' => '76',
            'symptoms' => 'Paciente asintomático, control de rutina.',
            'diagnosis' => 'Hipertensión controlada. Paciente estable.',
            'treatment' => 'Continuar tratamiento actual. Mantener dieta baja en sodio.',
            'prescription' => 'Enalapril 10mg - Continuar 1 tableta cada 24 horas por 90 días.'
        ]);

        ClinicalRecord::create([
            'patient_id' => $patientCarlos->id,
            'doctor_id' => $doctorMendoza->id,
            'record_date' => Carbon::today()->setHour(10)->setMinute(0),
            'weight' => '76',
            'height' => '175',
            'temperature' => '36.6',
            'blood_pressure' => '122/82',
            'heart_rate' => '78',
            'symptoms' => 'Somnolencia diurna, ronquidos nocturnos intensos.',
            'diagnosis' => 'Apnea obstructiva del sueño probable. Se solicita polisomnografía.',
            'treatment' => 'Derivar a neumología para estudio de sueño.',
            'prescription' => 'Educación sobre higiene del sueño.'
        ]);

        ClinicalRecord::create([
            'patient_id' => $patientAna->id,
            'doctor_id' => $doctorMendoza->id,
            'record_date' => Carbon::yesterday()->setHour(16)->setMinute(0),
            'weight' => '62',
            'height' => '165',
            'temperature' => '36.8',
            'blood_pressure' => '110/70',
            'heart_rate' => '72',
            'symptoms' => 'Palpitaciones ocasionales, sensación de vacío en el pecho.',
            'diagnosis' => 'Extrasístoles ventriculares benignas en contexto de ansiedad.',
            'treatment' => 'Manejo del estrés. Reducción de cafeína.',
            'prescription' => 'Propranolol 10mg - Tomar 1 tableta cada 12 horas por 30 días si hay síntomas.',
        ]);

        ClinicalRecord::create([
            'patient_id' => $patientPedro->id,
            'doctor_id' => $doctorMendoza->id,
            'record_date' => Carbon::today()->subDays(3)->setHour(9)->setMinute(0),
            'weight' => '70',
            'height' => '172',
            'temperature' => '36.4',
            'blood_pressure' => '125/85',
            'heart_rate' => '82',
            'symptoms' => 'Molestia en el pecho al hacer ejercicio.',
            'diagnosis' => 'Angina de esfuerzo estable. Se solicita prueba de esfuerzo.',
            'treatment' => 'Restricción de ejercicio intenso hasta resultados.',
            'prescription' => 'Nitroglicerina sublingual 0.4mg - 1 tableta cada 5 minutos si dolor, máximo 3 dosis.',
        ]);

        ClinicalRecord::create([
            'patient_id' => $patientMaria->id,
            'doctor_id' => $doctorMendoza->id,
            'record_date' => Carbon::today()->subDays(5)->setHour(11)->setMinute(0),
            'weight' => '65',
            'height' => '168',
            'temperature' => '36.6',
            'blood_pressure' => '115/75',
            'heart_rate' => '70',
            'symptoms' => 'Mareos al levantarse, fatiga general.',
            'diagnosis' => 'Hipotensión ortostática leve.',
            'treatment' => 'Aumentar ingesta de líquidos y sal moderada.',
            'prescription' => 'Hidratación abundante. Control de presión en casa.'
        ]);

        // ==================== NOTIFICACIONES DR. MENDOZA ====================
        $userDoctorId = $userDoctor->id;

        \App\Models\Notification::create([
            'user_id' => $userDoctorId,
            'type' => 'appointment',
            'title' => 'Nueva cita asignada',
            'message' => 'Se ha asignado una nueva cita para el paciente Pedro Sánchez el 24/05/2026 a las 15:00.',
            'read_at' => null,
        ]);

        \App\Models\Notification::create([
            'user_id' => $userDoctorId,
            'type' => 'system',
            'title' => 'Recordatorio',
            'message' => 'Tienes 4 citas programadas para hoy. Revisa tu agenda.',
            'read_at' => null,
        ]);

        \App\Models\Notification::create([
            'user_id' => $userDoctorId,
            'type' => 'clinical',
            'title' => 'Resultados de laboratorio',
            'message' => 'Resultados de exámenes de Juan Pérez están disponibles para revisión.',
            'read_at' => null,
        ]);

        \App\Models\Notification::create([
            'user_id' => $userDoctorId,
            'type' => 'appointment',
            'title' => 'Cita completada',
            'message' => 'La consulta con Carlos Ramírez ha sido marcada como completada.',
            'read_at' => null,
        ]);

        \App\Models\Notification::create([
            'user_id' => $userDoctorId,
            'type' => 'system',
            'title' => 'Actualización de agenda',
            'message' => 'Se ha añadido una nueva cita para el 26/05/2026 con Ana Martínez a las 11:30.',
            'read_at' => Carbon::now()->subHours(2),
        ]);

        \App\Models\Notification::create([
            'user_id' => $userDoctorId,
            'type' => 'system',
            'title' => 'Bienvenido',
            'message' => 'Bienvenido al panel médico de WebCitaSys. Revisa tu agenda del día.',
            'read_at' => null,
        ]);
    }
}
