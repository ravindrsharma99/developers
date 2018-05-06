<?php

use Illuminate\Database\Seeder;

class AppUsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\AppUser::class, 10)->create()->each(function ($u) {
            $u->testingDownloadRandomApp();
        });
    }
}
