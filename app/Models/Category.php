<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
	use HasFactory;

	protected $fillable = ['name', 'slug', 'image', 'icon'];

	//relacion de muchos a muchos
	public function brands()
	{
		return $this->belongsToMany(Brand::class);
	}

	//relacion de uno a muchos truncadas (a travez de)
	public function products()
	{
		return $this->hasManyThrough(Product::class, Subcategory::class);
	}

	//relacion de uno a muchos
	public function subcategories()
	{
		return $this->hasMany(Subcategory::class);
	}

	//URL amigables
	public function getRouteKeyName()
	{
		return 'slug';
	}
}
