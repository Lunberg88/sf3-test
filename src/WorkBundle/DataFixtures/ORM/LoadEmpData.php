<?php

namespace WorkBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use WorkBundle\Entity\Position;
use WorkBundle\Entity\Employee;

class LoadEmpData extends AbstractFixture implements OrderedFixtureInterface
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

            $emp = new Employee();
            $emp->setFio($fio[rand(0,3)]);
            $emp->setPosition($manager->merge($this->getReference('pos-'.rand(1,5))));
            $emp->setSalary(rand(2000, 3500));
            $emp->setDate(new \DateTime('2017-08-03'));

            $manager->persist($emp);
            $manager->flush();
        }
    }

    public function getOrder()
    {
        return 2;
    }
}