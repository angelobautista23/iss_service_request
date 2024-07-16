<?php

use Illuminate\Database\Seeder;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
     	date_default_timezone_set('Asia/Manila');
        DB::beginTransaction();

        try{
	        User::insert([
	        	'name' => 'Administrator',
                'username' => 'Administrator',
	            'email' => 'admin@local.dev',
                'status' => 1,
                'user_level' => 1,
                'attempt' => 0,
	            'password' => Hash::make('admin12345'),
	            'created_at' => date('Y-m-d'),
	            'updated_at' => date('Y-m-d'),
	        ]);

	        DB::commit();
            dd('Success');
	    }
	    catch(\Exception $e) {
            DB::rollback();
            dd($e);
        }
    }
}
