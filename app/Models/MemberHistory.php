<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemberHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'members_id',
        'visibility',
        'title',
        'notes',
        'others'
    ];

    public function member()
    {
        return $this->belongsTo(Member::class, 'members_id', 'id');
    }
}
