<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Patient extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'document_type',
        'document_number',
        'email',
        'phone',
        'birth_date',
        'gender',
        'blood_type',
        'address'
    ];

    protected $casts = [
        'birth_date' => 'date',
    ];

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function clinicalRecords()
    {
        return $this->hasMany(ClinicalRecord::class)->orderBy('record_date', 'desc');
    }

    public function nextAppointment()
    {
        return $this->hasOne(Appointment::class)
            ->whereIn('status', ['Pendiente', 'Confirmada'])
            ->whereDate('appointment_date', '>=', now())
            ->orderBy('appointment_date', 'asc');
    }

    // Accesor para nombre completo
    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    // Accesor para edad
    public function getAgeAttribute()
    {
        if (!$this->birth_date) {
            return 'N/A';
        }
        return Carbon::parse($this->birth_date)->age;
    }
}
