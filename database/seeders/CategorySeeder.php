<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // التصنيفات الرئيسية
        $mainCategories = [
            'تمور الموسم' => [
                'صفري 3',
                'سري 2',
                'مقفزي 2',
                'برجي 2',
                'خلاص 2',
                'صفري 3',
                'سري 2',
                'مقفزي 2',
                'برجي 2',
                'خلاص 2',
            ],
            'تمور أخرى' => [
                'تمور الفلة 3',
                'كبس المصنع 3',
                'مكنوز شعبي 3',
            ],
            'الشعبيات' => [
                'معمول 5',
                'دبس تمر 5',
                'كليجة 5',
                'تمرية 5',
                'تمر محشي 5',
                'صفري 3',
                'سري 2',
                'مقفزي 2',
                'برجي 2',
                'خلاص 2',
            ],
        ];

        foreach ($mainCategories as $mainName => $children) {
            $parent = Category::create([
                'name' => $mainName,
                'description' => "تصنيف رئيسي: $mainName",
                'parent_id' => null,
            ]);

            foreach ($children as $childName) {
                Category::create([
                    'name' => $childName,
                    'description' => "تصنيف فرعي: $childName",
                    'parent_id' => $parent->id,
                ]);
            }
        }
    }
}
