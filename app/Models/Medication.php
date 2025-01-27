<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medication extends Model
{
  use HasFactory;

  protected $fillable = [
    'user_id',
    'name',
    'dosage',
    'frequency',
    'medicationType',
    'startDate',
    'endDate',
    'instructions',
    'requiresFasting',
    'schedule',
    'status',
  ];

  protected $casts = [
    'requiresFasting' => 'boolean',
    'schedule' => 'array',
    'startDate' => 'date',
    'endDate' => 'date',
  ];

  public function user()
  {
    return $this->belongsTo(User::class);
  }
}
