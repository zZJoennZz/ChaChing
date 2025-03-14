<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    protected $fillable = [
        'online_ref_id',
        'member_id',
        'status',
        'email_address',
        'member_since_date',
    ];

    public function profile()
    {
        return $this->hasOne(MemberProfile::class, 'members_id', 'id');
    }

    public function subInformation()
    {
        return $this->hasMany(MemberSubInformation::class, 'members_id', 'id');
    }

    public function histories()
    {
        return $this->hasMany(History::class, 'members_id', 'id');
    }
}
