<?php

namespace WorkBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use WorkBundle\Entity\Position;

class LoadPositionData extends AbstractFixture implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $pos = new Position();
        $pos->setNumber('1');
        $pos->setParent('0');
        $pos->setName('Director');
        $manager->persist($pos);

        $pos1 = new Position();
        $pos1->setNumber('2');
        $pos1->setParent('1');
        $pos1->setName('Commercial Director');
        $manager->persist($pos1);

        $pos2 = new Position();
        $pos2->setNumber('3');
        $pos2->setParent('2');
        $pos2->setName('Tech Director');
        $manager->persist($pos2);

        $pos3 = new Position();
        $pos3->setNumber('4');
        $pos3->setParent('3');
        $pos3->setName('Talent Manager');
        $manager->persist($pos3);

        $pos4 = new Position();
        $pos4->setNumber('5');
        $pos4->setParent('4');
        $pos4->setName('Worker');
        $manager->persist($pos4);

        $this->addReference('pos1', $pos);
        $this->addReference('pos2', $pos1);
        $this->addReference('pos3', $pos2);
        $this->addReference('pos4', $pos3);
        $this->addReference('pos5', $pos4);

        $manager->flush();

    }

    public function getOrder()
    {
        return 1;
    }
}