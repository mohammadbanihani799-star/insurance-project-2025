<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;
class Insurance extends Model
{
    use HasFactory , SoftDeletes;

    // ===================================================================================================================
    // ============================================== Standard Section ===================================================
    // ===================================================================================================================
    protected $table = 'insurances';
    protected $fillable = [
        'insurance_type',
        'image',
        'price',
        'status',
    ];

    // ===================================================================================================================
    // =========================================== Relationship Section ==================================================
    // ===================================================================================================================

    public function insuranceBenefits()
    {
        return $this->hasMany(InsuranceBenefit::class, 'insurance_id');
    }

    public function insuranceRequests()
    {
        return $this->hasMany(InsuranceRequest::class, 'insurance_id');
    }

    // ===================================================================================================================
    // ============================================= Accessors Section ===================================================
    // ===================================================================================================================


    // status_label - للعرض فقط
    public function getStatusLabelAttribute()
    {
        if ($this->attributes['status'] == 1) {
            return 'Active';
        } elseif ($this->attributes['status'] == 2) {
            return 'Inactive';
        }
        return 'Unknown';
    }

    // insurance_type_label - للعرض فقط
    public function getInsuranceTypeLabelAttribute()
    {
        if ($this->attributes['insurance_type'] == 1) {
            return 'ضد الغير';
        } elseif ($this->attributes['insurance_type'] == 2) {
            return 'شامل';
        }
        return 'Unknown';
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
