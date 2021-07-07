<?php

use Illuminate\Database\Seeder;
use App\User;
Use App\Role;
use App\UserRole;
class AdminDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create(['type' => 'Admin', 'description' => 'Admin']);
        Role::create(['type' => 'User', 'description' => 'User']);

        User::create([
        	'name'		=>	'Admin',
        	'email'		=>	'admin@admin.com',
        	'password'	=>	bcrypt('admin'),
        	'role_id'	=> 	(Role::where('type','Admin')->first())->id
        ]);

        User::create([
        	'name'		=>	'User',
        	'email'		=>	'user@user.com',
        	'password'	=>	bcrypt('admin'),
        	'role_id'	=> 	(Role::where('type','User')->first())->id
        ]);

        /*Roles Types
      		1: 'Expense'
      		2: 'User'
        */
       
       UserRole::create([
       		'role_id'	=> (Role::where('type','Admin')->first())->id,
       		'type'		=> 1,
       ]);

    

       UserRole::create([
       		'role_id'	=> (Role::where('type','User')->first())->id,
       		'type'		=> 2,
       ]);
    }
}
