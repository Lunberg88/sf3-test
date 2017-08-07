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
        $f_names = [
            '0' => 'Max',
            '1' => 'Serg',
            '2' => 'Nikita',
            '3' => 'Nazar',
            '4' => 'Igor',
            '5' => 'Alexandr',
            '6' => 'Mixail',
            '7' => 'Andreyi',
            '8' => 'Nikolayi',
            '9' => 'Alexei',
        ];

        $f_last = [
            '0' => 'Fadeev',
            '1' => 'Konoval',
            '2' => 'Pavlov',
            '3' => 'Sushak',
            '4' => 'Nesterchuk',
            '5' => 'Popov',
            '6' => 'Kuzymin',
            '7' => 'Talashow',
            '8' => 'Molotov',
            '9' => 'Chernov',
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

        for($x=1; $x<194; $x++) {
            $emp = new Employee();
            $emp->setFio($f_names[rand(0,9)].$f_last[rand(0,9)]);
            $emp->setPosition($manager->merge($this->getReference('pos-5')));
            $emp->setSalary($rsalary[rand(0,7)]);
            $emp->setDate(new \DateTime('2017-'.rand(6,9).'-'.rand(1,30)));
            $manager->persist($emp);
            $manager->flush();
        }

        for($x=1; $x<6; $x++) {
            $emp = new Employee();
            $emp->setFio($f_names[rand(0,9)].$f_last[rand(0,9)]);
            $emp->setPosition($manager->merge($this->getReference('pos-4')));
            $emp->setSalary(4000 + ($x*110));
            $emp->setDate(new \DateTime('2017-'.rand(6,8).'-'.rand(1,30)));
            $manager->persist($emp);
            $manager->flush();
        }

        $emp1 = new Employee();
        $emp1->setFio('Maratov Andreyi');
        $emp1->setPosition($manager->merge($this->getReference('pos-1')));
        $emp1->setSalary('16500');
        $emp1->setDate(new \DateTime('2017-05-15'));
        $manager->persist($emp1);
        $manager->flush();

        $emp2 = new Employee();
        $emp2->setFio('Dmitryi Korchev');
        $emp2->setPosition($manager->merge($this->getReference('pos-2')));
        $emp2->setSalary('12500');
        $emp2->setDate(new \DateTime('2017-05-27'));
        $manager->persist($emp2);
        $manager->flush();

        $emp3 = new Employee();
        $emp3->setFio('Vasilyi Gaidayi');
        $emp3->setPosition($manager->merge($this->getReference('pos-3')));
        $emp3->setSalary('10500');
        $emp3->setDate(new \DateTime('2017-06-12'));
        $manager->persist($emp3);
        $manager->flush();


    }

    public function getOrder()
    {
        return 2;
    }
}