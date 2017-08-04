<?php

namespace WorkBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use WorkBundle\Entity\Emp;

class LoadUserData extends AbstractFixture implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        for($x=1; $x<20; $x++) {
            $fio = [
              '0' => 'Max Fadeev',
              '1' => 'Serg Konoval',
              '2' => 'Nikita Pavlov',
              '3' => 'Nazar Sushak',
            ];

            $emp = new Emp();
            $emp->setFio($fio[rand(0,3)]);
            $emp->setPos($manager->merge(rand($this->getReference('pos2'), $this->getReference('pos5'))));
            $emp->setSalary(rand(2000, 3500));
            $emp->setDate(new \DateTime('2017-08-03'));

            $manager->persist($emp);
            $manager->flush();
        }
    }

    public function getOrder()
    {
        return 1;
    }
}