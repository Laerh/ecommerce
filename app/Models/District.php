<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'city_id'];

    //relacion de uno a muchos
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
