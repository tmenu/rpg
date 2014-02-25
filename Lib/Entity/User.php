<?php

namespace Lib\Entity;

class User extends Entity
{
    protected $id;
    protected $usernma;
    protected $password;
    protected $salt;

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
     * Gets the value of usernma.
     *
     * @return mixed
     */
    public function getUsernma()
    {
        return $this->usernma;
    }

    /**
     * Sets the value of usernma.
     *
     * @param mixed $usernma the usernma
     *
     * @return self
     */
    public function setUsernma($usernma)
    {
        $this->usernma = $usernma;

        return $this;
    }

    /**
     * Gets the value of password.
     *
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Sets the value of password.
     *
     * @param mixed $password the password
     *
     * @return self
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Gets the value of salt.
     *
     * @return mixed
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * Sets the value of salt.
     *
     * @param mixed $salt the salt
     *
     * @return self
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;

        return $this;
    }
}