<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Travel extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'destination',
        'start_date',
        'end_date',
        'purpose',
        'status',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'status' => 'integer',
    ];

    /**
     * العلاقة: السفر ينتمي لمستخدم واحد
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
