<?php

namespace Lib\Entity;

class Map_monster extends Entity
{
	protected $ref_map;
	protected $ref_monster;
    
    protected $position_x;
    protected $position_y;

    protected $direction;

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
     * Gets the value of ref_monster.
     *
     * @return mixed
     */
    public function getRef_monster()
    {
        return $this->ref_monster;
    }

    /**
     * Sets the value of ref_monster.
     *
     * @param mixed $ref_monster the ref_monster
     *
     * @return self
     */
    public function setRef_monster($ref_monster)
    {
        $this->ref_monster = $ref_monster;

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

    /**
     * Gets the value of direction.
     *
     * @return mixed
     */
    public function getDirection()
    {
        return $this->direction;
    }

    /**
     * Sets the value of direction.
     *
     * @param mixed $direction the direction
     *
     * @return self
     */
    public function setDirection($direction)
    {
        $this->direction = $direction;

        return $this;
    }
}