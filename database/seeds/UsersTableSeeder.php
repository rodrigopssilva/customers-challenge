<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Administrator',
            'email' => 'nimda@admin.com',
            'password' => Hash::make('secret'),
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
        factory(App\Models\User::class, 50)->create();
    }
}
