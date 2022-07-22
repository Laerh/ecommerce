<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ColorProduct extends Model
{
    use HasFactory;

    protected $table = "color_product";

    //relacion uno a muchos inversa
    public function color()
    {
        return $this->belongsTo(Color::class);
    }
    //relacion uno a muchos inversa
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
