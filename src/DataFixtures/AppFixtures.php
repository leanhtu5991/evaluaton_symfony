<?php

namespace App\DataFixtures;

use App\Entity\Users;
use App\Entity\Questions;
use App\Entity\Answers;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');
        // user
        $numUsers = 0;
        $entitiesUsers = [];
        for ($i = 0; $i < 10; $i++) {
            $numUsers++;
            $user = new Users;
            $user->setName($faker->name);
            $entitiesUsers[] = $user;
            $manager->persist($user);
        }
        // question
        $titles = ["history", "sport", "social", "economy"];
        $numTitles = count($titles);
        $numQuestions = 0;
        $entitiesQuestions =[];
        while ($numQuestions < 20) {
            $question = new Questions;
            $question->setTitle($titles[rand(0, $numTitles - 1 )]);
            $question->setContent($faker->text);
            $question->setUser($entitiesUsers[rand(0, $numUsers - 1 )]);
            $numQuestions++;
            // $entitiesQuestions[] = $question;
            $manager->persist($question);

            // answer
            $numAnswer = rand(0,3);
            for($i = 0; $i<$numAnswer; $i++){
                $answer = new Answers;
                $answer->setContent($faker->text);
                $answer->setStatus($faker->boolean);
                $answer->setQuestion($question);
                $manager->persist($answer);
            }
        }
        
        
        
        $manager->flush();
    }
}
