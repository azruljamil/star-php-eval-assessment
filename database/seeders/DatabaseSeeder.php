<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $stories = [
            'World' => ['Cities work together to tackle rising temperatures', 'Local volunteers bring fresh food to families', 'New research tracks changes in global rainfall', 'Communities restore a historic public library'],
            'Business' => ['Small businesses find new markets close to home', 'Local makers invest in greener production', 'A new generation of entrepreneurs opens its doors', 'Markets look ahead to a busy trading season'],
            'Technology' => ['Researchers explore a better way to store energy', 'Students build tools to improve accessibility', 'New technology helps farmers monitor their crops', 'How public libraries are closing the digital divide'],
            'Culture' => ['Artists turn an old station into a creative space', 'A community festival celebrates its many voices', 'The stories behind a city\'s changing music scene', 'Young filmmakers find an audience at home'],
            'Sports' => ['Young athletes prepare for a new season', 'Community teams make room for everyone', 'Local runners take to the streets for charity', 'Coaches share lessons from a memorable season'],
        ];
        foreach ($stories as $name => $titles) {
            $category = Category::firstOrCreate(['name' => $name]);
            foreach ($titles as $index => $title) {
                $permalink = Str::slug($title);
                if (! Article::where('permalink', $permalink)->exists()) {
                    $factory = Article::factory()->for($category);
                    if ($index === 3) {
                        $factory = $factory->draft();
                    }
                    $factory->create(['title' => $title, 'permalink' => $permalink]);
                }
            }
        }
    }
}
