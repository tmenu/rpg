<?php

namespace Lib\Entity;

class Personnage extends Entity
{
	/* STATISTIQUES */
    protected $health;
	protected $strength;
	protected $resistance;
	protected $speed;
	protected $posture;
    protected $round;

    /* INFOS PERSONNELLES */
    protected $name;
    protected $position;
    protected $direction;
    protected $ref;
    protected $faceset;
    protected $skin;

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
     * Gets the value of position.
     *
     * @return mixed
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Sets the value of position.
     *
     * @param mixed $position the position
     *
     * @return self
     */
    public function setPosition($position)
    {
        $this->position = $position;

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

    /**
     * Gets the value of faceset.
     *
     * @return mixed
     */
    public function getFaceset()
    {
        return $this->faceset;
    }

    /**
     * Sets the value of faceset.
     *
     * @param mixed $faceset the faceset
     *
     * @return self
     */
    public function setFaceset($faceset)
    {
        $this->faceset = $faceset;

        return $this;
    }

    /**
     * Gets the value of skin.
     *
     * @return mixed
     */
    public function getSkin()
    {
        return $this->skin;
    }

    /**
     * Sets the value of skin.
     *
     * @param mixed $skin the skin
     *
     * @return self
     */
    public function setSkin($skin)
    {
        $this->skin = $skin;

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
}