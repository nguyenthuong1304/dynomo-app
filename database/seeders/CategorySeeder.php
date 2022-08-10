<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $list = [
            'Sức khoẻ',
            'Ví điện tử',
            'ATM',
            'Tiền mặt',
            'Mua sắm',
            'Ăn uống & nhà hàng',
            'Giải trí & đời sống',
            'Sinh hoạt & di chuyển',
            'Thu nhập',
            'Khác',
        ];

        collect($list)
            ->map(fn ($l) => Category::create(['name' => $l]));
    }
}
