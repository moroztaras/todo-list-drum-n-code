<?php

namespace App\DataFixtures;

use App\Entity\Task;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Ramsey\Uuid\Nonstandard\Uuid;

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
            $subTask1 = (new Task())
                ->setTitle($faker->title.rand(1, 100))
                ->setDescription((string) $faker->realText())
                ->setStatus(Task::TASK_STATUS_TODO)
                ->setPriority(rand(1, 5))
                ->setCompletedAt(new \DateTimeImmutable())
                ->setUuid(Uuid::uuid4())
                ->setUser($admin)
            ;

            $task1 = (new Task())
                ->setTitle($faker->title.rand(1, 100))
                ->setDescription((string) $faker->realText())
                ->setStatus(Task::TASK_STATUS_TODO)
                ->setPriority(rand(1, 5))
                ->setCompletedAt(new \DateTimeImmutable())
                ->setUuid(Uuid::uuid4())
                ->setUser($admin)
                ->setSubTack($subTask1)
            ;

            $subTask2 = (new Task())
                ->setTitle($faker->title.rand(1, 100))
                ->setDescription((string) $faker->realText())
                ->setStatus(Task::TASK_STATUS_TODO)
                ->setPriority(rand(1, 5))
                ->setCompletedAt(new \DateTimeImmutable())
                ->setUuid(Uuid::uuid4())
                ->setUser($admin)
            ;
            $task2 = (new Task())
                ->setTitle($faker->title.rand(1, 100))
                ->setDescription((string) $faker->realText())
                ->setStatus(Task::TASK_STATUS_TODO)
                ->setPriority(rand(1, 5))
                ->setCompletedAt(new \DateTimeImmutable())
                ->setUuid(Uuid::uuid4())
                ->setUser($user)
                ->setSubTack($subTask2)
            ;

            $manager->persist($subTask1);
            $manager->persist($task1);
            $manager->persist($subTask2);
            $manager->persist($task2);
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
