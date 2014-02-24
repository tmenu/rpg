<?php

namespace Lib\Perso;

abstract class Personnage
{
	protected $health;
	protected $strength;
	protected $resistance;
	protected $speed;
	protected $posture;



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
}