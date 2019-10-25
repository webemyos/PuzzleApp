<?php


namespace Core\Entity\Entity;


class Request
{
    private $Core;
    private $select;
    private $from;
    private $joins = array();

    function __construct($core)
    {
        $this->Core = $core;
    }

    /**
     * Défine the Entity Who Want
     */
    function Select($select)
    {
        $this->select = $select;
        return $this;
    }

    /**
     * Define the Entity Selected
     */
    function From($from)
    {
        $this->from = $from;
        return $this;
    }

    /**
     * Add A join
     */
    function Join($join)
    {
        $this->joins[] = $join;
        return $this;
    }

    function Where()
    {
        return $this;
    }

    function Run()
    {}

}