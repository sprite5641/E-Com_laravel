<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admins')->delete();
        $adminRecords = [
            ['id'=>1,'name'=>'admin','type'=>'admin','phone'=>'0843737885','email'=>'admin@admin.com',
            'password'=>'$2y$10$tGkCu3o/dWVkx4RduT1hjuiTtxeHqmJfu7KHf21JiKuXgYYhxbef2','image'=>'','status'=>1
            ],
            ['id'=>2,'name'=>'john','type'=>'admin','phone'=>'0843737885','email'=>'john@admin.com',
            'password'=>'$2y$10$tGkCu3o/dWVkx4RduT1hjuiTtxeHqmJfu7KHf21JiKuXgYYhxbef2','image'=>'','status'=>1
            ],
            ['id'=>3,'name'=>'steve','type'=>'admin','phone'=>'0843737885','email'=>'steve@admin.com',
            'password'=>'$2y$10$tGkCu3o/dWVkx4RduT1hjuiTtxeHqmJfu7KHf21JiKuXgYYhxbef2','image'=>'','status'=>1
            ],
            ['id'=>4,'name'=>'amit','type'=>'admin','phone'=>'0843737885','email'=>'amit@admin.com',
            'password'=>'$2y$10$tGkCu3o/dWVkx4RduT1hjuiTtxeHqmJfu7KHf21JiKuXgYYhxbef2','image'=>'','status'=>1
            ],
        ];
        
        DB::table('admins')->insert($adminRecords);
        
        // foreach ($adminRecords as $key => $record) {
        //     \App\Admin::create($record);
        // }
    }
}
