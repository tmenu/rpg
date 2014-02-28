<?php

namespace Lib\Entity;

class Map_item extends Entity
{
	protected $ref_map;
	protected $ref_item;
    
    protected $position_x;
    protected $position_y;


    /**
     * Gets the value of ref_map.
     *
     * @return mixed
     */
    public function getRef_map()
    {
        return $this->ref_map;
    }

    /**
     * Sets the value of ref_map.
     *
     * @param mixed $ref_map the ref_map
     *
     * @return self
     */
    public function setRef_map($ref_map)
    {
        $this->ref_map = $ref_map;

        return $this;
    }

    /**
     * Gets the value of ref_item.
     *
     * @return mixed
     */
    public function getRef_item()
    {
        return $this->ref_item;
    }

    /**
     * Sets the value of ref_item.
     *
     * @param mixed $ref_item the ref_item
     *
     * @return self
     */
    public function setRef_item($ref_item)
    {
        $this->ref_item = $ref_item;

        return $this;
    }

    /**
     * Gets the value of position_x.
     *
     * @return mixed
     */
    public function getPosition_x()
    {
        return $this->position_x;
    }

    /**
     * Sets the value of position_x.
     *
     * @param mixed $position_x the position_x
     *
     * @return self
     */
    public function setPosition_x($position_x)
    {
        $this->position_x = $position_x;

        return $this;
    }

    /**
     * Gets the value of position_y.
     *
     * @return mixed
     */
    public function getPosition_y()
    {
        return $this->position_y;
    }

    /**
     * Sets the value of position_y.
     *
     * @param mixed $position_y the position_y
     *
     * @return self
     */
    public function setPosition_y($position_y)
    {
        $this->position_y = $position_y;

        return $this;
    }
}