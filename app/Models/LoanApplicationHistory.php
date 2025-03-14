<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoanApplicationHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'loan_applications_id',
        'visibility',
        'title',
        'notes',
        'others',
    ];

    public function loan_application()
    {
        return $this->belongsTo(LoanApplication::class, 'id', 'loan_applications_id');
    }
}
