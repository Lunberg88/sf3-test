<?php

namespace WorkBundle\Entity;

/**
 * Emp
 */
class Emp
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $fio;

    /**
     * @var int
     */
    private $pos;

    /**
     * @var int
     */
    private $salary;

    /**
     * @var \DateTime
     */
    private $date;

    private $position;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set fio
     *
     * @param string $fio
     *
     * @return Emp
     */
    public function setFio($fio)
    {
        $this->fio = $fio;

        return $this;
    }

    /**
     * Get fio
     *
     * @return string
     */
    public function getFio()
    {
        return $this->fio;
    }

    /**
     * Set pos
     *
     * @param integer $pos
     *
     * @return Emp
     */
    public function setPos($pos)
    {
        $this->pos = $pos;

        return $this;
    }

    /**
     * Get pos
     *
     * @return int
     */
    public function getPos()
    {
        return $this->pos;
    }

    /**
     * Set salary
     *
     * @param integer $salary
     *
     * @return Emp
     */
    public function setSalary($salary)
    {
        $this->salary = $salary;

        return $this;
    }

    /**
     * Get salary
     *
     * @return int
     */
    public function getSalary()
    {
        return $this->salary;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Emp
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }
}

