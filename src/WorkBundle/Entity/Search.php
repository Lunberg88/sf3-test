<?php

namespace WorkBundle\Entity;


class Search
{
    /**
     * @var $id
     */
    protected $id;
    /**
     * @var $field
     */
    protected $field;

    /**
     * @return field
     */
    public function getField()
    {
        return $this->field;
    }

    /**
     * @param $field
     */
    public function setField($field)
    {
        $this->field = $field;
    }
}