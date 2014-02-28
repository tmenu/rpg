<?php

namespace Lib\Model;

use Lib\Router;
use Lib\Utils;
use Lib\Manager;

use Lib\Entity\Entity;
use Lib\Entity\Map_item;

abstract class Map_itemModel extends Model
{
	public function selectAll()
	{
		die('not develop yet');

		$request = $this->pdo->prepare('SELECT * FROM ' . $this->type . '_map_item');
        $request->execute();

        $results = $request->fetchAll();

        $map_item_list = array();

        foreach ($request->fetchAll() as $map_item)
        {
            $map_item_list[] = new Map_item($map_item);
        }

        return $map_item_list;
	}

	public function select($id)
	{
		die('not develop yet');
	}

	public function selectByMap($ref_map)
	{
		// Lecture des monstres d'une map particulière
		$request = $this->pdo->prepare('SELECT * FROM ' . $this->type . '_map_item WHERE ref_map = :ref_map');
        $request->bindValue(':ref_map', $ref_map, \PDO::PARAM_INT);
        $request->execute();

        // Conversion en objet
        $map_items = array();

        foreach ($request->fetchAll() as $map_item)
        {
        	$map_items[] = new Map_item( $map_item );
        }

        return $map_items;
	}

	protected function insert(Entity $map_item)
	{
		$request = $this->pdo->prepare('INSERT INTO ' . $this->type . '_map_item
										SET ref_map     = :ref_map,
											ref_item = :ref_item,
											position_x  = :position_x,
											position_y  = :position_y');

		$request->bindValue(':ref_map',     $map_item->getRef_map(),     \PDO::PARAM_INT);
		$request->bindValue(':ref_item', 	$map_item->getRef_item(), 	 \PDO::PARAM_INT);
		$request->bindValue(':position_x',  $map_item->getPosition_x(),  \PDO::PARAM_INT);
		$request->bindValue(':position_y',  $map_item->getPosition_y(),  \PDO::PARAM_INT);

		$request->execute();
	}

	protected function update(Entity $entity)
	{
		die('not develop yet');
	}

	public function delete($id)
	{
		$request = $this->pdo->prepare('DELETE FROM ' . $this->type . '_map_item WHERE id = :id');
        $request->bindValue(':id', $id);
        $request->execute();
	}

	public function deleteByItem($ref_item)
	{
		$request = $this->pdo->prepare('DELETE FROM ' . $this->type . '_map_item WHERE ref_item = :ref_item');
        $request->bindValue(':ref_item', $ref_item);
        $request->execute();
	}
}