<?php

use Illuminate\Database\Seeder;
use App\Product;
class ProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $productRecords = [
            ['id'=>1,'category_id'=>4,'section_id'=>1,'brand_id'=>'1','product_name'=>'Blue Casual T-Shirt',
            'product_code'=>'BT001','product_color'=>'Blue','product_price'=>'1500',
            'product_discount'=>10,'product_weight'=>200,'main_image'=>'',
            'description'=>'Test product','fabric'=>'','pattern'=>'',
            'sleeve'=>'','fit'=>'','occasion'=>'','is_featured'=>'No','status'=>1],
            ['id'=>2,'category_id'=>4,'section_id'=>1,'brand_id'=>'2','product_name'=>'Red Casual T-Shirt',
            'product_code'=>'R001','product_color'=>'Red','product_price'=>'2000',
            'product_discount'=>10,'product_weight'=>200,'main_image'=>'',
            'description'=>'Test product','fabric'=>'','pattern'=>'',
            'sleeve'=>'','fit'=>'','occasion'=>'','is_featured'=>'Yes','status'=>1]
        ];
        Product::insert($productRecords);
    }
}
