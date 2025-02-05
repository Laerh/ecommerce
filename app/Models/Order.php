<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at', 'status'];

    const PENDIENTE = 1;
    const PAGADO = 2;
    const ENVIADO = 3;
    const ENTREGADO = 4;
    const ANULADO = 5;

    //relacion uno a muchos inversa
    public function city()
    {
        return $this->belongsTo(City::class);
    }

    //relacion uno a muchos inversa
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    //relacion uno a muchos inversa
    public function district()
    {
        return $this->belongsTo(District::class);
    }

    //relacion uno a muchos inversa
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
