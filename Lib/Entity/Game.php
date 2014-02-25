<?php

namespace Lib\Entity;

use Lib\Manager;

class Game extends Entity
{
    protected $ref_user;
    protected $ref_map;
    protected $ref_character;

    protected $user      = null;
    protected $map       = null;
    protected $character = null;

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

    /**
     * Gets the value of user.
     *
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Sets the value of user.
     *
     * @param mixed $user the user
     *
     * @return self
     */
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Gets the value of map.
     *
     * @return mixed
     */
    public function getMap()
    {
        return $this->map;
    }

    /**
     * Sets the value of map.
     *
     * @param mixed $map the map
     *
     * @return self
     */
    public function setMap($map)
    {
        $this->map = $map;

        return $this;
    }

    /**
     * Gets the value of character.
     *
     * @return mixed
     */
    public function getCharacter()
    {
        return $this->character;
    }

    /**
     * Sets the value of character.
     *
     * @param mixed $character the character
     *
     * @return self
     */
    public function setCharacter($character)
    {
        $this->character = $character;

        return $this;
    }
}