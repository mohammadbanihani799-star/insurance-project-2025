<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'name_ar',
        'name_en',
        'description',
        'status',
        'department_type_id',
    ];

    protected $casts = [
        'status' => 'integer',
    ];

    /**
     * العلاقة: القسم يحتوي على عدة موظفين
     */
    public function users()
    {
        return $this->hasMany(User::class, 'department_id');
    }

    /**
     * Scope: فلترة الأقسام النشطة فقط
     */
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }
}
