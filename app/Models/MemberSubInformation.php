<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemberSubInformation extends Model
{
    use HasFactory;

    protected $fillable = [
        'members_id',
        'information_type',
        'sub_information'
    ];

    protected $casts = [
        'sub_information' => 'json' // Automatically decode JSON data
    ];

    public function member()
    {
        return $this->belongsTo(Member::class, 'members_id', 'id');
    }
}
