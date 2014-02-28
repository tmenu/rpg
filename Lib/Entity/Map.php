<?php

namespace Lib\Entity;

use Lib\Entity\Monster;
use Lib\Entity\Item;

class Map extends Entity
{
	protected $name;

	// Taille de la plateforme
	protected $size_height = 6;
	protected $size_width  = 6;

	// Dimensions visible
	protected $visible_x = 6;
	protected $visible_y = 6;

	// Position du coin supérieur gauche
	protected $origin_x = 0;
	protected $origin_y = 0;

	protected $map = array();  // Données de la map

    protected $monsters = array();
    protected $items = array();

	// Type de cases
	CONST WALL   = 0x01; // Mur : accés impossible
	CONST GROUND = 0x02; // Sol : accès possible
	CONST ENTRY  = 0x04; // Entrée de la map
	CONST OUT    = 0x08; // Sortie de la map

    CONST MOUNTAIN  = 0x10;
    CONST MOUNTAIN2 = 0x20;
    CONST GRASS     = 0x40;

    CONST DESERT  = 0x100;
    CONST DESERT2 = 0x200;
    CONST SAND    = 0x400;

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
     * Gets the value of size_height.
     *
     * @return mixed
     */
    public function getSize_height()
    {
        return $this->size_height;
    }

    /**
     * Sets the value of size_height.
     *
     * @param mixed $size_height the size_height
     *
     * @return self
     */
    public function setSize_height($size_height)
    {
        $this->size_height = (int)$size_height;

        return $this;
    }

    /**
     * Gets the value of size_width.
     *
     * @return mixed
     */
    public function getSize_width()
    {
        return $this->size_width;
    }

    /**
     * Sets the value of size_width.
     *
     * @param mixed $size_width the size_width
     *
     * @return self
     */
    public function setSize_width($size_width)
    {
        $this->size_width = (int)$size_width;

        return $this;
    }

    /**
     * Gets the value of visible_x.
     *
     * @return mixed
     */
    public function getVisible_x()
    {
        return $this->visible_x;
    }

    /**
     * Sets the value of visible_x.
     *
     * @param mixed $visible_x the visible_x
     *
     * @return self
     */
    public function setVisible_x($visible_x)
    {
        $this->visible_x = (int)$visible_x;

        return $this;
    }

    /**
     * Gets the value of visible_y.
     *
     * @return mixed
     */
    public function getVisible_y()
    {
        return $this->visible_y;
    }

    /**
     * Sets the value of visible_y.
     *
     * @param mixed $visible_y the visible_y
     *
     * @return self
     */
    public function setVisible_y($visible_y)
    {
        $this->visible_y = (int)$visible_y;

        return $this;
    }

    /**
     * Gets the value of origin_x.
     *
     * @return mixed
     */
    public function getOrigin_x()
    {
        return $this->origin_x;
    }

    /**
     * Sets the value of origin_x.
     *
     * @param mixed $origin_x the origin_x
     *
     * @return self
     */
    public function setOrigin_x($origin_x)
    {
        $this->origin_x = (int)$origin_x;

        return $this;
    }

    /**
     * Gets the value of origin_y.
     *
     * @return mixed
     */
    public function getOrigin_y()
    {
        return $this->origin_y;
    }

    /**
     * Sets the value of origin_y.
     *
     * @param mixed $origin_y the origin_y
     *
     * @return self
     */
    public function setOrigin_y($origin_y)
    {
        $this->origin_y = (int)$origin_y;

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
     * Gets the value of monsters.
     *
     * @return mixed
     */
    public function getMonsters()
    {
        return $this->monsters;
    }

    /**
     * Sets the value of monsters.
     *
     * @param mixed $monsters the monsters
     *
     * @return self
     */
    public function setMonsters(array $monsters)
    {
        $this->monsters = $monsters;

        return $this;
    }

    public function addMonster(Monster $monster)
    {
        $this->monsters[] = $monster;

        return $this;
    }

    /**
     * Gets the value of items.
     *
     * @return mixed
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * Sets the value of items.
     *
     * @param mixed $items the items
     *
     * @return self
     */
    public function setItems($items)
    {
        $this->items = $items;

        return $this;
    }

    public function addItem(Item $item)
    {
        $this->items[] = $item;

        return $this;
    }
}