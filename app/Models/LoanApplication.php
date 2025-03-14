<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoanApplication extends Model
{
    use HasFactory;

    protected $fillable = [
        'loan_id',
        'member_id',
        'status',
        'data',
    ];

    public function histories()
    {
        return $this->hasMany(LoanApplicationHistory::class, 'loan_applications_id', 'id');
    }
}
