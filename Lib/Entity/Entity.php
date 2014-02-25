<?php

namespace Lib\Entity;

abstract class Entity
{
	protected $id = null;

    public function __construct(array $data = array())
    {
        $this->hydrate($data);
    }

    private function hydrate(array $data)
    {
        foreach ($data as $key => $value)
        {
            $method = 'set' . ucfirst($key);

            if (method_exists($this, $method)) {
                $this->$method($value);
            }
        }
    }

    public function isNew()
    {
        return ($this->id === null) ? true : false;
    }

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
}