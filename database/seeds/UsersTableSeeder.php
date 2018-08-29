<?php

use Illuminate\Database\Seeder;
use App\Role;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $role_admin  = Role::where('name', 'admin')->first();



      $employee = new User();
      $employee->name = 'user';
      $employee->email = 'user@gmail.com';
      $employee->password = bcrypt('secret');
      $employee->role_id =3 ;
      $employee->save();

      $manager = new User();
      $manager->name = 'admin';
      $manager->email = 'admin@gmail.com';
      $manager->password = bcrypt('admin');
       $manager->role_id =2 ;
      $manager->save();

      $super = new User();
      $super->name = 'Jony';
      $super->email = 'dobson@dobson.io';
      $super->password = bcrypt('Jonas2018');
       $super->role_id =1 ;
      $super->save();
   
      $super = new User();
      $super->name = 'Gise';
      $super->email = 'roominagii@gmail.com';
      $super->password = bcrypt('roominagii');
       $super->role_id =1 ;
      $super->save();
   
      $super = new User();
      $super->name = 'Rodrigo';
      $super->email = 'rsbertoa90@gmail.com';
      $super->password = bcrypt('rsbertoa90');
       $super->role_id =1 ;
      $super->save();
   
      $super = new User();
      $super->name = 'Fede';
      $super->email = 'fgobea@flopsolutions.com';
      $super->password = bcrypt('fgobea');
       $super->role_id =1 ;
      $super->save();  
   

      // factory(App\User::class,50)->create();
    }
}
