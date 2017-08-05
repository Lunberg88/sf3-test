<?php

namespace WorkBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Position
 */
class Position
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var int
     */
    private $number;

    /**
     * @var int
     */
    private $parentId;

    /**
     * @var string
     */
    private $name;

    /**
     * @var int
     */
    private $position;


    protected $employee = array();

    public function getEmployee()
    {
        return $this->employee;
    }

    public function __construct()
    {
        $this->employee = new ArrayCollection();
    }

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
     * Set number
     *
     * @param integer $number
     *
     * @return Position
     */
    public function setNumber($number)
    {
        $this->number = $number;

        return $this;
    }

    /**
     * Get number
     *
     * @return int
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * Set parentId
     *
     * @param integer $parentId
     *
     * @return Position
     */
    public function setParentId($parentId)
    {
        $this->parentId = $parentId;

        return $this;
    }

    /**
     * Get parentId
     *
     * @return int
     */
    public function getParentId()
    {
        return $this->parentId;
    }

    public function setPosition(Position $position = null)
    {
        $this->position = $position;

        return $this;
    }

    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Position
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param Employee $employee
     * @return $this
     */
    public function addEmployee(Employee $employee)
    {
        $this->employee[] = $employee;
        return $this;
    }

    public function __toString()
    {
        return $this->getName();
    }
}

