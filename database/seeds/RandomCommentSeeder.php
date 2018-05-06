<?php

use Illuminate\Database\Seeder;

class RandomCommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i = 0; $i < 10 ; $i++){
            $this->runOnce();
        }
    }

    public function runOnce(){
        $faker = Faker\Factory::create();
        // get random app
        $app = \App\NewApp::where('status', 'active')
        ->where('app_status', \App\NewApp::STATUS_approved)
        ->inRandomOrder()->first();

        // get random user
        $user = \App\AppUser::inRandomOrder()->first();

        $app->addComment($user, [
            'comment' => $faker->text,
            'rating' => rand(1,5)
        ]);
    }
}
