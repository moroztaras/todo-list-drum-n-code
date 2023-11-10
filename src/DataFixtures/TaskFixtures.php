<?php

namespace App\DataFixtures;

use App\Entity\Task;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class TaskFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('EN_en');

        /** @var User $admin */
        $admin = $this->getReference(UserFixtures::USER_ADMIN);
        /** @var User $user */
        $user = $this->getReference(UserFixtures::USER);

        for ($i = 1; $i <= 5; ++$i) {
//            $task = (new Task())
//                ->setTitle($faker->title)
//                ->setDescription($faker->text)
//                ->setStatus(Task::TASK_STATUS_TODO)
//                ->setPriority(rand(1,5))
//                ->
//
//            ;
//
//            $manager->persist($task);
        }

        for ($i = 1; $i <= 5; ++$i) {
            $twitter = (new Twitter())
                ->setText($faker->word)
                ->setPhoto('Motivation.jpeg')
                ->setVideo('https://www.youtube.com/embed/19tIt3D_yiI')
                ->setUser($user)
                ->setUuid(Uuid::uuid4())
            ;

            $manager->persist($twitter);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
        ];
    }
}
