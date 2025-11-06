<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectWorkingEmployee extends Model
{
    use HasFactory;

    protected $table = 'project_working_employees';

    protected $fillable = [
        'project_id',
        'employee_id',
        'employee_type',
        'role',
        'assigned_date',
    ];

    protected $casts = [
        'assigned_date' => 'date',
    ];

    /**
     * العلاقة: الموظف العامل ينتمي لمشروع واحد
     */
    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    /**
     * العلاقة: الموظف العامل ينتمي لمستخدم (موظف) واحد
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'employee_id');
    }
}
