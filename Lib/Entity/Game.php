<?php

namespace Lib\Entity;

class Game extends Entity
{
    protected $id;
    protected $ref_user;
    protected $ref_map;
    protected $ref_character;

    /**
     * Gets the value of id.
     *
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Sets the value of id.
     *
     * @param mixed $id the id
     *
     * @return self
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Gets the value of ref_user.
     *
     * @return mixed
     */
    public function getRef_user()
    {
        return $this->ref_user;
    }

    /**
     * Sets the value of ref_user.
     *
     * @param mixed $ref_user the ref_user
     *
     * @return self
     */
    public function setRef_user($ref_user)
    {
        $this->ref_user = $ref_user;

        return $this;
    }

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
     * Gets the value of ref_character.
     *
     * @return mixed
     */
    public function getRef_character()
    {
        return $this->ref_character;
    }

    /**
     * Sets the value of ref_character.
     *
     * @param mixed $ref_character the ref_character
     *
     * @return self
     */
    public function setRef_character($ref_character)
    {
        $this->ref_character = $ref_character;

        return $this;
    }
}