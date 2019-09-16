<?php

use Illuminate\Database\Seeder;
use App\Item;
use App\SubItem;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Item::class, 5)
            ->create()
            ->each(function ($post) {
                $subitems = factory(App\SubItem::class, 2)->make();
                $post->subitems()->saveMany($subitems);
            });
    }
}
