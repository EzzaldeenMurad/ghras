<?php

namespace Database\Seeders;

use App\Models\Image;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::create([
            'name' => 'تمور مقفزي',
            'category_id' => 4,
            'user_id' => 2,
            'price' => 100,
            'description' => "<p><strong>النوع:</strong> تمر طازجة منتقاة بعناية من نخيل المنطقة.</p><p><strong>المنشأ:</strong> مزارع معروفة بجودة تمورها.</p><p><strong>المذاق:</strong> مميزة بطعمها الحلو الطبيعي وقوامها الطري اللين.</p><p><strong>الفوائد الصحية:</strong> غنية بالألياف والفيتامينات والمعادن، تعزز صحة الجهاز الهضمي وتقوي المناعة.</p><p><strong>طرق الاستخدام المقترحة:</strong> وجبة خفيفة، أو إضافة إلى السلطات والحلويات.</p>",
        ]);

        Product::create([
            'name' => 'تمور سكري',
            'category_id' => 3,
            'user_id' => 2,
            'price' => 120,
            'description' => "<p><strong>النوع:</strong> تمر سكري فاخر.</p><p><strong>المنشأ:</strong> مزارع مشهورة بجودة إنتاجها.</p><p><strong>المذاق:</strong> طعم سكري لذيذ وقوام ناعم.</p><p><strong>الفوائد الصحية:</strong> مصدر طبيعي للطاقة، غني بالمعادن والفيتامينات.</p><p><strong>طرق الاستخدام المقترحة:</strong> تناوله كوجبة خفيفة أو مع القهوة.</p>",
        ]);

        Product::create([
            'name' => 'تمور خلاص',
            'category_id' => 5,
            'user_id' => 2,
            'price' => 90,
            'description' => "<p><strong>النوع:</strong> تمر خلاص عالي الجودة.</p><p><strong>المنشأ:</strong> مزارع تقليدية معروفة.</p><p><strong>المذاق:</strong> طعم غني وقوام متماسك.</p><p><strong>الفوائد الصحية:</strong> يعزز صحة القلب ويحتوي على مضادات الأكسدة.</p><p><strong>طرق الاستخدام المقترحة:</strong> مثالي مع الحليب أو إضافته إلى الحلويات.</p>",
        ]);

        Product::create([
            'name' => 'تمور عجوة',
            'category_id' => 2,
            'user_id' => 4,
            'price' => 150,
            'description' => "<p><strong>النوع:</strong> تمر عجوة فاخر.</p><p><strong>المنشأ:</strong> المدينة المنورة.</p><p><strong>المذاق:</strong> طعم مميز وقوام ناعم.</p><p><strong>الفوائد الصحية:</strong> يساعد في تحسين الهضم ويقوي المناعة.</p><p><strong>طرق الاستخدام المقترحة:</strong> تناوله صباحاً أو إضافته إلى العصائر.</p>",
        ]);

        Product::create([
            'name' => 'تمور برحي',
            'category_id' => 6,
            'user_id' => 2,
            'price' => 80,
            'description' => "<p><strong>النوع:</strong> تمر برحي طازج.</p><p><strong>المنشأ:</strong> مزارع محلية.</p><p><strong>المذاق:</strong> طعم حلو طبيعي وقوام طري.</p><p><strong>الفوائد الصحية:</strong> غني بالألياف ويساعد على تحسين صحة الجهاز الهضمي.</p><p><strong>طرق الاستخدام المقترحة:</strong> تناوله كوجبة خفيفة أو إضافته إلى السلطات.</p>",
        ]);

        Image::create([
            'image_url' => 'images/products/1.png',
            'imageable_id' => 1,
            'imageable_type' => Product::class,
        ]);
        Image::create([
            'image_url' => 'images/products/2.png',
            'imageable_id' => 1,
            'imageable_type' => Product::class,
        ]);
        Image::create([
            'image_url' => 'images/products/2.png',
            'imageable_id' => 2,
            'imageable_type' => Product::class,
        ]);
        Image::create([
            'image_url' => 'images/products/3.png',
            'imageable_id' => 3,
            'imageable_type' => Product::class,
        ]);
        Image::create([
            'image_url' => 'images/products/3.png',
            'imageable_id' => 4,
            'imageable_type' => Product::class,
        ]);
        Image::create([
            'image_url' => 'images/products/5.png',
            'imageable_id' => 3,
            'imageable_type' => Product::class,
        ]);
        Image::create([
            'image_url' => 'images/products/5.png',
            'imageable_id' => 5,
            'imageable_type' => Product::class,
        ]);
        Image::create([
            'image_url' => 'images/products/6.png',
            'imageable_id' => 4,
            'imageable_type' => Product::class,
        ]);
        Image::create([
            'image_url' => 'images/products/6.png',
            'imageable_id' => 6,
            'imageable_type' => Product::class,
        ]);
    }
}
