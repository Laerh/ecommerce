<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
	use HasFactory;

	protected $fillable = ['name'];

	//relacion muchos a muchos
	public function categories() {
		return $this->belongsToMany(Category::class);
	}

	//relacion uno a muchos
	public function products() {
		return $this->hasMany(Category::class);
	}
}
