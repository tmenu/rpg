<?php

namespace Lib\Entity;

class Initial_character extends Entity
{
	/* STATISTIQUES */
    protected $health_max;
    protected $health;
	protected $strength;
	protected $resistance;
	protected $speed;
	protected $posture;
    protected $round;

    /* INFOS PERSONNELLES */
    protected $id;
    protected $name;
    protected $position_x;
    protected $position_y;
    protected $direction;
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
     * Sets the value of healthMax.
     *
     * @param mixed $healthMax the health max
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
     * Gets the value of posture.
     *
     * @return mixed
     */
    public function getPosture()
    {
        return $this->posture;
    }

    /**
     * Sets the value of posture.
     *
     * @param mixed $posture the posture
     *
     * @return self
     */
    public function setPosture($posture)
    {
        $this->posture = $posture;

        return $this;
    }

    /**
     * Gets the value of round.
     *
     * @return mixed
     */
    public function getRound()
    {
        return $this->round;
    }

    /**
     * Sets the value of round.
     *
     * @param mixed $round the round
     *
     * @return self
     */
    public function setRound($round)
    {
        $this->round = $round;

        return $this;
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