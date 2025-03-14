<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemberProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'members_id',
        'first_name',
        'middle_name',
        'last_name',
        'gender',
        'birthday',
        'civil_status',
        'house_status',
        'name_on_check',
        'employment_date',
        'contributions_percentage',
        'tin_number',
        'phone_number_1',
        'phone_number_2',
        'address_1',
        'regions_id',
        'provinces_id',
        'cities_id',
        'barangays_id',
        'countries_id',
        'employee_number',
        'employee_status',
        'college_or_department',
        'photo',
        'signature'
    ];

    public function member()
    {
        return $this->belongsTo(Member::class, 'members_id', 'id');
    }
}
