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
        for($x=1; $x<200; $x++) {
            $fio = [
              '0' => 'Max Fadeev',
              '1' => 'Serg Konoval',
              '2' => 'Nikita Pavlov',
              '3' => 'Nazar Sushak',
              '4' => 'Igor Nesterchuk',
              '5' => 'Alexandr Popov',
              '6' => 'Mixail Kuzymin',
              '7' => 'Andreyi Talashow',
              '8' => 'Nikolayi Molotov',
              '9' => 'Alexei Chernov',
            ];

            $rsalary = [
              '0' => 2000,
              '1' => 2200,
              '2' => 2400,
              '3' => 2800,
              '4' => 3100,
              '5' => 3400,
              '6' => 3500,
              '7' => 4000,
            ];

            $emp = new Employee();
            $emp->setFio($fio[rand(0,9)]);
            $emp->setPosition($manager->merge($this->getReference('pos-'.rand(2,5))));
            $emp->setSalary($rsalary[rand(0,7)]);
            $emp->setDate(new \DateTime('2017-08-03'));
            $manager->persist($emp);
            $manager->flush();
        }

        $emp1 = new Employee();
        $emp1->setFio('Maratov Andreyi');
        $emp1->setPosition($manager->merge($this->getReference('pos-1')));
        $emp1->setSalary('16500');
        $emp1->setDate(new \DateTime('2017-05-01'));
        $manager->persist($emp1);
        $manager->flush();
    }

    public function getOrder()
    {
        return 2;
    }
}