<?php

namespace Lib\Model;

use Lib\Router;
use Lib\Utils;
use Lib\Manager;

use Lib\Entity\Entity;
use Lib\Entity\Item;
use Lib\Entity\Map_item;

abstract class ItemModel extends Model
{
	public function selectAll()
	{
		die('not develop yet');

		$request = $this->pdo->prepare('SELECT * FROM ' . $this->type . '_item');
        $request->execute();

        $results = $request->fetchAll();

        $item_list = array();

        foreach ($results as $result)
        {
            $item_list[] = new Item($result);
        }

        return $item_list;
	}

	public function select($id)
	{
		$request = $this->pdo->prepare('SELECT * FROM ' . $this->type . '_item WHERE id = :id');
        $request->bindValue(':id', $id);
        $request->execute();

        if(($result = $request->fetch()) != false)
        {
            return new Item($result);
        }
        else
        {
            return false;
        }
	}

	protected function insert(Entity $item)
	{
		$request = $this->pdo->prepare('INSERT INTO ' . $this->type . '_item
										SET health_max = :health_max,
											health     = :health,
											strength   = :strength,
											resistance = :resistance,
											speed	   = :speed,
											life	   = :life,
											name       = :name,
											position_x = :position_x,
											position_y = :position_y,
											ref		   = :ref');

		$request->bindValue(':health_max', $item->getHealth_max(), \PDO::PARAM_INT);
		$request->bindValue(':health', 	   $item->getHealth(), \PDO::PARAM_INT);
		$request->bindValue(':strength',   $item->getStrength(), \PDO::PARAM_INT);
		$request->bindValue(':resistance', $item->getResistance(), \PDO::PARAM_INT);
		$request->bindValue(':speed', 	   $item->getSpeed(), \PDO::PARAM_INT);
		$request->bindValue(':life',       $item->getLife(),  \PDO::PARAM_INT);
		$request->bindValue(':name', 	   $item->getName());
		$request->bindValue(':position_x', $item->getPosition_x(), \PDO::PARAM_INT);
		$request->bindValue(':position_y', $item->getPosition_y(), \PDO::PARAM_INT);
		$request->bindValue(':ref', 	   $item->getRef());

		if ($request->execute() != false) {
            $item->setId( $this->pdo->lastInsertId() );

            return $item;
        }
        else {
        	echo 'quelque chose';
            return false;
        }
	}

	protected function update(Entity $entity)
	{
		$request = $this->pdo->prepare('UPDATE ' . $this->type . '_item
										SET health_max = :health_max,
											health     = :health,
											strength   = :strength,
											resistance = :resistance,
											speed	   = :speed,
											life	   = :life,
											id 		   = :id,
											name       = :name,
											position_x = :position_x,
											position_y = :position_y,
											ref		   = :ref
										WHERE id = :id');

		$request->bindValue(':health_max', $entity->getHealth_max(), \PDO::PARAM_INT);
		$request->bindValue(':health', 	   $entity->getHealth(), \PDO::PARAM_INT);
		$request->bindValue(':strength',   $entity->getStrength(), \PDO::PARAM_INT);
		$request->bindValue(':resistance', $entity->getResistance(), \PDO::PARAM_INT);
		$request->bindValue(':speed', 	   $entity->getSpeed(), \PDO::PARAM_INT);
		$request->bindValue(':life',   	   $entity->getLife());
		$request->bindValue(':name', 	   $entity->getName());
		$request->bindValue(':position_x', $entity->getPosition_x(), \PDO::PARAM_INT);
		$request->bindValue(':position_y', $entity->getPosition_y(), \PDO::PARAM_INT);
		$request->bindValue(':ref', 	   $entity->getRef());

		$request->bindValue(':id', $entity->getId(),  \PDO::PARAM_INT);


		if ($request->execute() != false) {
            return $entity;
        }
        else {
            return false;
        }
	}

	public function delete($id)
	{
		$request = $this->pdo->prepare('DELETE FROM ' . $this->type . '_item WHERE id = :id');
        $request->bindValue(':id', $id);
        $request->execute();
	}
}