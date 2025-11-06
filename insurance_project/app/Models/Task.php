<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'user_id',
        'status',
        'due_date',
        'priority',
    ];

    protected $casts = [
        'due_date' => 'date',
        'status' => 'integer',
    ];

    /**
     * العلاقة: المهمة تنتمي لمستخدم واحد
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
