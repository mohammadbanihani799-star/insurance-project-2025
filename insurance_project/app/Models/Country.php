<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'name_ar',
        'name_en',
        'code',
        'phone_code',
        'flag',
        'status',
    ];

    protected $casts = [
        'status' => 'integer',
    ];

    /**
     * العلاقة: الدولة تحتوي على عدة مستخدمين (مفتاح الهاتف الشخصي)
     */
    public function usersWithPersonalPhone()
    {
        return $this->hasMany(User::class, 'country_phone_id');
    }

    /**
     * العلاقة: الدولة تحتوي على عدة مستخدمين (مفتاح هاتف العمل)
     */
    public function usersWithWorkPhone()
    {
        return $this->hasMany(User::class, 'work_country_phone_id');
    }

    /**
     * Scope: فلترة الدول النشطة فقط
     */
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }
}
