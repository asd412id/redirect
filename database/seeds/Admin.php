<?php

use Illuminate\Database\Seeder;
use App\User;

class Admin extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$user = new User;
		$user->name = "Administrator";
		$user->email = "admin@shortlink.az";
		$user->password = bcrypt('adminPassword');
		$user->email_verified_at = now();
		$user->save();
	}
}
