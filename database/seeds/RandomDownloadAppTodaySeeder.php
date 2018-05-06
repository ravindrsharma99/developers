<?php

use Illuminate\Database\Seeder;
use App\AppUser;

class RandomDownloadAppTodaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i = 0 ; $i < 10 ; $i++){
            $this->runOnce();
        }
    }

    public function runOnce(){
        $user = AppUser::inRandomOrder()
        ->first();

        $user->testingDownloadRandomApp(false);
    }
}
