<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, SoftDeletes;

    // ===================================================================================================================
    // ============================================== Standard Section ===================================================
    // ===================================================================================================================
    protected $table = 'users';
    
    protected $fillable = [
        'name',
        'email',
        'phone',
        'country_phone_id',
        'status',
        'password',
        'employee_type_id',
        'image',
        'department_id',
        'gender',
        'marital_status',
        'date_of_birth',
        'country_id',
        'city_id',
        'nationality',
        'date_of_hiring',
        'date_termination',
        'address',
        'salary',
        'work_email',
        'work_phone',
        'work_country_phone_id'
    ];
    
    protected $hidden = [
        'password',
        'remember_token',
    ];
    
    protected $casts = [
        'email_verified_at' => 'datetime',
        'date_of_birth'     => 'date',
        'date_of_hiring'    => 'date',
        'date_termination'  => 'date',
        'salary'            => 'decimal:2',
        'status'            => 'integer',
        'gender'            => 'integer',
        'marital_status'    => 'integer',
    ];

    // لو عندك Guards متعددة (اختياري):
    // protected $guard_name = 'web';

    // ===================================================================================================================
    // =========================================== Relationship Section ==================================================
    // ===================================================================================================================

    public function tasks()
    {
        return $this->hasMany(Task::class, 'user_id');
    }

    public function travels()
    {
        return $this->hasMany(Travel::class, 'user_id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }
    // m=>m
    public function projects()
    {
        return $this->belongsToMany(Project::class, 'project_employees')->withTimestamps();
    }

    public function projectSalesman()
    {
        return $this->hasMany(Project::class, 'project_salesman');
    }


    public function supervisorDesigner()
    {
        return $this->hasMany(Project::class, 'design_supervisor_id');
    }

    public function projectCoordinator()
    {
        return $this->hasMany(Project::class, 'project_project_coordinator_name');
    }

    public function projectWorkingEmployees()
    {
        return $this->hasMany(ProjectWorkingEmployee::class, 'employee_id');
    }


    
    public function employeeType()
    {
        return $this->belongsTo(EmployeeType::class, 'employee_type_id');
    }



    // =========== Created By :  Raghad Karasneh================
    public function countryPhoneKey()
    {
        return $this->belongsTo(Country::class, 'country_phone_id');
    }

    public function workCountryPhoneKey()
    {
        return $this->belongsTo(Country::class, 'work_country_phone_id');
    }

    // ===================================================================================================================
    // ============================================== Mutators Section ===================================================
    // ===================================================================================================================
    
    /**
     * تجزئة كلمة المرور تلقائياً عند الحفظ
     * يمنع تخزين كلمات المرور بدون تشفير
     */
    public function setPasswordAttribute($value): void
    {
        // إذا كانت القيمة موجودة وليست مجزّأة بالفعل
        if ($value && Hash::needsRehash($value)) {
            $this->attributes['password'] = Hash::make($value);
        } else {
            // في حال كانت القيمة مجزّأة مسبقاً (من Seeder مثلاً)
            $this->attributes['password'] = $value;
        }
    }

    // ===================================================================================================================
    // ============================================= Accessors Section ===================================================
    // ===================================================================================================================
    
    /**
     * احصل على تسمية الحالة (Status Label)
     * يحافظ على القيمة الأصلية في DB ويوفر label منفصل
     */
    public function getStatusLabelAttribute(): ?string
    {
        return match ((int) $this->attributes['status'] ?? 0) {
            1 => 'Active',
            2 => 'Inactive',
            default => null,
        };
    }

    /**
     * احصل على تسمية الجنس (Gender Label)
     */
    public function getGenderLabelAttribute(): ?string
    {
        return match ((int) $this->attributes['gender'] ?? 0) {
            1 => 'Male',
            2 => 'Female',
            default => null,
        };
    }

    /**
     * احصل على تسمية الحالة الاجتماعية (Marital Status Label)
     */
    public function getMaritalStatusLabelAttribute(): ?string
    {
        return match ((int) $this->attributes['marital_status'] ?? 0) {
            1 => 'Single',
            2 => 'Married',
            3 => 'Divorced',
            4 => 'Widow/Widower',
            default => null,
        };
    }

    // ===================================================================================================================
    // =============================================== Scopes Section ====================================================
    // ===================================================================================================================

    // status
    public function scopeStatus($query, $value)
    {
        return $query->where('status', $value); // 1 => Active || 2 => Inactive
    }
}
