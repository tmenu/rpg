<?php

namespace Lib\Entity;

class Item extends Entity
{
	/* STATISTIQUES */
    protected $health_max;
    protected $health;
	protected $strength;
	protected $resistance;
	protected $speed;
	protected $life;

    /* INFOS PERSONNELLES */
    protected $name;
    protected $position_x;
    protected $position_y;
    protected $ref;

    /**
     * Gets the value of health_max.
     *
     * @return mixed
     */
    public function getHealth_max()
    {
        return $this->health_max;
    }

    /**
     * Sets the value of health_max.
     *
     * @param mixed $health_max the health_max
     *
     * @return self
     */
    public function setHealth_max($health_max)
    {
        $this->health_max = $health_max;

        return $this;
    }

    /**
     * Gets the value of health.
     *
     * @return mixed
     */
    public function getHealth()
    {
        return $this->health;
    }

    /**
     * Sets the value of health.
     *
     * @param mixed $health the health
     *
     * @return self
     */
    public function setHealth($health)
    {
        $this->health = $health;

        return $this;
    }

    /**
     * Gets the value of strength.
     *
     * @return mixed
     */
    public function getStrength()
    {
        return $this->strength;
    }

    /**
     * Sets the value of strength.
     *
     * @param mixed $strength the strength
     *
     * @return self
     */
    public function setStrength($strength)
    {
        $this->strength = $strength;

        return $this;
    }

    /**
     * Gets the value of resistance.
     *
     * @return mixed
     */
    public function getResistance()
    {
        return $this->resistance;
    }

    /**
     * Sets the value of resistance.
     *
     * @param mixed $resistance the resistance
     *
     * @return self
     */
    public function setResistance($resistance)
    {
        $this->resistance = $resistance;

        return $this;
    }

    /**
     * Gets the value of speed.
     *
     * @return mixed
     */
    public function getSpeed()
    {
        return $this->speed;
    }

    /**
     * Sets the value of speed.
     *
     * @param mixed $speed the speed
     *
     * @return self
     */
    public function setSpeed($speed)
    {
        $this->speed = $speed;

        return $this;
    }

    /**
     * Gets the value of life.
     *
     * @return mixed
     */
    public function getLife()
    {
        return $this->life;
    }

    /**
     * Sets the value of life.
     *
     * @param mixed $life the life
     *
     * @return self
     */
    public function setLife($life)
    {
        $this->life = $life;

        return $this;
    }

    /**
     * Gets the value of name.
     *
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Sets the value of name.
     *
     * @param mixed $name the name
     *
     * @return self
     */
    public function setName($name)
    {
        $this->name = $name;

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
     * Gets the value of ref.
     *
     * @return mixed
     */
    public function getRef()
    {
        return $this->ref;
    }

    /**
     * Sets the value of ref.
     *
     * @param mixed $ref the ref
     *
     * @return self
     */
    public function setRef($ref)
    {
        $this->ref = $ref;

        return $this;
    }
}