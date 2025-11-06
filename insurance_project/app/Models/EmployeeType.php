<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeType extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'title_ar',
        'title_en',
        'description',
        'status',
    ];

    protected $casts = [
        'status' => 'integer',
    ];

    /**
     * العلاقة: نوع الموظف يحتوي على عدة موظفين
     */
    public function users()
    {
        return $this->hasMany(User::class, 'employee_type_id');
    }

    /**
     * Scope: فلترة الأنواع النشطة فقط
     */
    public function scopeStatus($query, int $status)
    {
        return $query->where('status', $status);
    }
}
