<?php


use App\User;

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

    	User::truncate();
	    	// create user
	        User::create([
	        	'username' => 'user1234',
	        	'email'   =>  'user1234@gmail.com',
	        	'password' => bcrypt('user'),
	        ]);
    	
    }
}
