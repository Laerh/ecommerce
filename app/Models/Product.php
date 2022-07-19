<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
	use HasFactory;

	const BORRADOR = 1;
	const PUBLICADO = 2;

	protected $guarded = ['id', 'created_at', 'updated_at'];

	//relacion de uno a muchos inversa
	public function brand()
	{
		return $this->belongsTo(Brand::class);
	}

	//relacion de muchos a muchos
	public function colors()
	{
		return $this->belongsToMany(Color::class)->withPivot('quantity');
	}

	//relacion de uno a muchos polimorfica
	public function images()
	{
		return $this->morphMany(Image::class, 'imageable');
	}

	//relacion de uno a muchos
	public function sizes()
	{
		return $this->hasMany(Size::class);
	}

	//relacion de uno a muchos inversa
	public function subcategory()
	{
		return $this->belongsTo(Subcategory::class);
	}

	//URL amigables
	public function getRouteKeyName()
	{
		return 'slug';
	}
}
