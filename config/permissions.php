<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Role-Based Permissions Matrix
    |--------------------------------------------------------------------------
    |
    | Define all roles and their associated permissions.
    | '*' means full access to that module.
    |
    */

    'roles' => [
        'admin' => [
            'name' => 'Administrador',
            'description' => 'Acceso completo a todos los módulos del sistema.',
            'permissions' => ['*'],
        ],

        'doctor' => [
            'name' => 'Profesional de la Salud',
            'description' => 'Gestión de citas asignadas, historial clínico y atención a pacientes.',
            'permissions' => [
                'appointments.view_assigned',
                'appointments.update_status',
                'clinical_records.view',
                'clinical_records.create',
                'clinical_records.edit',
                'patients.view',
                'patients.search',
                'schedule.view_own',
                'dashboard.view_doctor',
                'reports.view_personal',
            ],
        ],

        'receptionist' => [
            'name' => 'Recepcionista',
            'description' => 'Registro de pacientes, agendamiento de citas y gestión de agenda diaria.',
            'permissions' => [
                'patients.view',
                'patients.create',
                'patients.edit',
                'patients.search',
                'appointments.view',
                'appointments.create',
                'appointments.edit',
                'appointments.cancel',
                'appointments.view_agenda',
                'dashboard.view_receptionist',
            ],
        ],

        'financial' => [
            'name' => 'Gerente Financiero',
            'description' => 'Reportes financieros, estadísticas de citas y exportación de datos.',
            'permissions' => [
                'reports.view_financial',
                'reports.view_statistics',
                'reports.export',
                'appointments.view_statistics',
                'dashboard.view_financial',
            ],
        ],

        'support' => [
            'name' => 'Soporte Técnico',
            'description' => 'Monitoreo del sistema, logs de error y gestión de incidencias.',
            'permissions' => [
                'system.view_logs',
                'system.monitor',
                'system.manage_incidents',
                'users.reset_passwords',
                'users.view',
                'dashboard.view_support',
            ],
        ],

        'patient' => [
            'name' => 'Paciente',
            'description' => 'Acceso a información personal, citas propias e historial médico.',
            'permissions' => [
                'appointments.view_own',
                'appointments.create_own',
                'appointments.cancel_own',
                'clinical_records.view_own',
                'profile.manage',
                'dashboard.view_patient',
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Module Definitions
    |--------------------------------------------------------------------------
    |
    | Define specific actions per module for granular permission checking.
    |
    */
    'modules' => [
        'patients' => [
            'label' => 'Pacientes',
            'actions' => ['view', 'create', 'edit', 'delete', 'search'],
        ],
        'appointments' => [
            'label' => 'Citas',
            'actions' => ['view', 'create', 'edit', 'cancel', 'update_status', 'view_agenda', 'view_assigned', 'view_own', 'create_own', 'cancel_own', 'view_statistics'],
        ],
        'clinical_records' => [
            'label' => 'Historial Clínico',
            'actions' => ['view', 'create', 'edit', 'delete', 'view_own'],
        ],
        'reports' => [
            'label' => 'Reportes',
            'actions' => ['view_financial', 'view_statistics', 'export', 'view_personal'],
        ],
        'users' => [
            'label' => 'Usuarios',
            'actions' => ['manage', 'view', 'create', 'edit', 'delete', 'assign_roles', 'reset_passwords'],
        ],
        'schedule' => [
            'label' => 'Horarios',
            'actions' => ['manage', 'view_own', 'configure'],
        ],
        'system' => [
            'label' => 'Sistema',
            'actions' => ['view_logs', 'monitor', 'manage_incidents'],
        ],
        'dashboard' => [
            'label' => 'Dashboard',
            'actions' => ['view_admin', 'view_doctor', 'view_receptionist', 'view_financial', 'view_support', 'view_patient'],
        ],
        'profile' => [
            'label' => 'Perfil',
            'actions' => ['manage'],
        ],
    ],
];
