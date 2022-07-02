<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$categories = [
			[
				'name' => 'Celulares y tablets',
				'slug' => Str::slug('Celulares y tables'),
				'icon' => '<i class="fa-solid fa-mobile-screen-button"></i>'
			],
			[
				'name' => 'Tv audio y video',
				'slug' => Str::slug('Tv audio y video'),
				'icon' => '<i class="fa-solid fa-tv"></i>'
			],
			[
				'name' => 'Consola y videojuegos',
				'slug' => Str::slug('Consola y videojuegos'),
				'icon' => '<i class="fa-solid fa-gamepad"></i>'
			],
			[
				'name' => 'Computación',
				'slug' => Str::slug('Computación'),
				'icon' => '<i class="fa-solid fa-computer"></i>'
			],
			[
				'name' => 'Moda',
				'slug' => Str::slug('Moda'),
				'icon' => '<i class="fa-solid fa-shirt"></i>'
			]
		];

		foreach ($categories as $category) {
			$category = Category::factory(1)->create($category)->first();
			$brands = Brand::factory(4)->create();
			foreach ($brands as $brand) {
				$brand->categories()->attach($category->id);
			}
		}
	}
}
