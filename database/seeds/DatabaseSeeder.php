<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(AdminTableSeeder::class);
    }
}
class AdminTableSeeder extends Seeder
{
     public function run()
    {
        DB::table('users')->insert(
            [
                [
                    'name'     => 'Clone 3' ,
                    'email'    => 'clone3@gmail.com' , 
                    'password' => bcrypt('123456') ,
                ],
                [
                    'name'     => 'Clone 4' ,
                    'email'    => 'clone4@gmail.com' , 
                    'password' => bcrypt('123456') ,
                ],
                [
                    'name'     => 'Clone 1' ,
                    'email'    => 'clone1@gmail.com' , 
                    'password' => bcrypt('123456') ,
                ],
                [
                    'name'     => 'Clone 2' ,
                    'email'    => 'clone2@gmail.com' , 
                    'password' => bcrypt('123456') ,
                ],
            ]
        );
    }
}