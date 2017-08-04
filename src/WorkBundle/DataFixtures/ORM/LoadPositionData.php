<?php

namespace WorkBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use WorkBundle\Entity\Position;

class LoadPositionData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $pos = new Position();
        $pos->setNumber('1');
        $pos->setName('Director');
        $manager->persist($pos);
        $this->addReference('pos1', $pos);
        $manager->flush();


        $pos1 = new Position();
        $pos1->setNumber('2');
        $pos1->setPosition($manager->merge($this->getReference('pos1')));
        //$pos1->setParentId('1');
        $pos1->setName('Commercial Director');
        $manager->persist($pos1);
        $this->addReference('pos2', $pos1);
        $manager->flush();



        $pos2 = new Position();
        $pos2->setNumber('3');
        $pos2->setPosition($manager->merge($this->getReference('pos2')));
        //$pos2->setParentId('2');
        $pos2->setName('Tech Director');
        $manager->persist($pos2);
        $this->addReference('pos3', $pos2);
        $manager->flush();

        $pos3 = new Position();
        $pos3->setNumber('4');
        $pos3->setPosition($manager->merge($this->getReference('pos3')));
        //$pos3->setParentId('3');
        $pos3->setName('Talent Manager');
        $manager->persist($pos3);
        $this->addReference('pos4', $pos3);
        $manager->flush();

        $pos4 = new Position();
        $pos4->setNumber('5');
        $pos4->setPosition($manager->merge($this->getReference('pos4')));
        //$pos4->setParentId('4');
        $pos4->setName('Worker');
        $manager->persist($pos4);
        $this->addReference('pos5', $pos4);
        $manager->flush();

        $this->addReference('pos-1', $pos);
        $this->addReference('pos-2', $pos1);
        $this->addReference('pos-3', $pos2);
        $this->addReference('pos-4', $pos3);
        $this->addReference('pos-5', $pos4);

        $manager->flush();

    }

    public function getOrder()
    {
        return 1;
    }
}