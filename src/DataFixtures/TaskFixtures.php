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
            $task = (new Task())
                ->setTitle($faker->title)
                ->setDescription($faker->text)
                ->setStatus(Task::TASK_STATUS_TODO)
                ->setPriority(rand(1,5))
                ->setCompletedAt(new \DateTimeImmutable())
                ->setUuid(Uuid::uuid4())
                ->setUser($admin);

            $manager->persist($task);
        }

        for ($i = 1; $i <= 5; ++$i) {
            $task = (new Task())
                ->setTitle($faker->title)
                ->setDescription($faker->text)
                ->setStatus(Task::TASK_STATUS_TODO)
                ->setPriority(rand(1,5))
                ->setCompletedAt(new \DateTimeImmutable())
                ->setUuid(Uuid::uuid4())
                ->setUser($user);

            $manager->persist($task);
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
