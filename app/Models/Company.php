<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = [
        'name',
        'owner_name',
        'billing_email',
    ];


    // todos los usuarios admin empresa de esta compañia (por si quieres más de uno)
	public function admins()
	{
	    return $this->hasMany(User::class)->where('role_id', 2);
	}

	// admin principal (si quieres uno solo)
	public function mainAdmin()
	{
	    return $this->hasOne(User::class)->where('role_id', 2);
	}

    public function branches()
    {
        return $this->hasMany(Branch::class);
    }

    public function schedules()
	{
	    return $this->hasMany(Schedule::class);
	}
}
