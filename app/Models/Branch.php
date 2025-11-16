<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use HasFactory;

    // 👇 Campos que se pueden asignar con create() / update()
    protected $fillable = [
        'company_id',
        'name',
        'address',
        'lat',
        'lng',
        'radius',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function schedules()
	{
	    return $this->hasMany(Schedule::class);
	}

}
