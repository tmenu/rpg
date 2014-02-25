<?php

namespace Lib\Entity;

class Map_monster extends Entity
{
	protected $ref_init_map;
	protected $ref_init_monster;

    /**
     * Gets the value of ref_init_map.
     *
     * @return mixed
     */
    public function getRef_init_map()
    {
        return $this->ref_init_map;
    }

    /**
     * Sets the value of ref_init_map.
     *
     * @param mixed $ref_init_map the ref_init_map
     *
     * @return self
     */
    public function setRef_init_map($ref_init_map)
    {
        $this->ref_init_map = $ref_init_map;

        return $this;
    }

    /**
     * Gets the value of ref_init_monster.
     *
     * @return mixed
     */
    public function getRef_init_monster()
    {
        return $this->ref_init_monster;
    }

    /**
     * Sets the value of ref_init_monster.
     *
     * @param mixed $ref_init_monster the ref_init_monster
     *
     * @return self
     */
    public function setRef_init_monster($ref_init_monster)
    {
        $this->ref_init_monster = $ref_init_monster;

        return $this;
    }
}