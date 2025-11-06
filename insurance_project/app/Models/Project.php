<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'name_ar',
        'name_en',
        'type',
        'status',
        'project_salesman',
        'design_supervisor_id',
        'project_project_coordinator_name',
        'programming_language_used_web',
        'programming_language_used_mobile',
        'description',
        'start_date',
        'end_date',
        'budget',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'budget' => 'decimal:2',
        'status' => 'integer',
        'type' => 'integer',
    ];

    /**
     * العلاقة: المشروع ينتمي لمندوب مبيعات (Salesman)
     */
    public function salesman()
    {
        return $this->belongsTo(User::class, 'project_salesman');
    }

    /**
     * العلاقة: المشروع ينتمي لمشرف تصميم
     */
    public function designSupervisor()
    {
        return $this->belongsTo(User::class, 'design_supervisor_id');
    }

    /**
     * العلاقة: المشروع ينتمي لمنسق مشروع
     * ⚠️ ملاحظة: اسم العمود غير معتاد، تأكد من اسمه في قاعدة البيانات
     */
    public function coordinator()
    {
        return $this->belongsTo(User::class, 'project_project_coordinator_name');
    }

    /**
     * العلاقة Many-to-Many: المشروع يحتوي على عدة موظفين
     */
    public function employees()
    {
        return $this->belongsToMany(User::class, 'project_employees')->withTimestamps();
    }

    /**
     * العلاقة: الموظفين العاملين على المشروع
     */
    public function projectWorkingEmployees()
    {
        return $this->hasMany(ProjectWorkingEmployee::class, 'project_id');
    }

    /**
     * Scope: فلترة المشاريع حسب الحالة
     */
    public function scopeByStatus($query, int $status)
    {
        return $query->where('status', $status);
    }
}
