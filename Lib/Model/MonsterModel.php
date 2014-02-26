<?php

namespace Lib\Model;

use Lib\Router;
use Lib\Utils;
use Lib\Manager;

use Lib\Entity\Entity;
use Lib\Entity\Monster;
use Lib\Entity\Map_monster;

abstract class MonsterModel extends Model
{
	public function selectAll()
	{
		die('not develop yet');

		$request = $this->pdo->prepare('SELECT * FROM ' . $this->type . '_monster');
        $request->execute();

        $results = $request->fetchAll();

        $character_list = array();

        foreach ($results as $result)
        {
            $character_list[] = new Monster($result);
        }

        return $character_list;
	}

	public function select($id)
	{
		$request = $this->pdo->prepare('SELECT * FROM ' . $this->type . '_monster WHERE id = :id');
        $request->bindValue(':id', $id);
        $request->execute();

        if(($result = $request->fetch()) != false)
        {
            return new Monster($result);
        }
        else
        {
            return false;
        }
	}

	protected function insert(Entity $monster)
	{
		$request = $this->pdo->prepare('INSERT INTO ' . $this->type . '_monster
										SET health_max = :health_max,
											health     = :health,
											strength   = :strength,
											resistance = :resistance,
											speed	   = :speed,
											posture	   = :posture,
											round 	   = :round,
											name       = :name,
											position_x = :position_x,
											position_y = :position_y,
											direction  = :direction,
											ref		   = :ref');

		$request->bindValue(':health_max', $monster->getHealth_max(), \PDO::PARAM_INT);
		$request->bindValue(':health', 	   $monster->getHealth(), \PDO::PARAM_INT);
		$request->bindValue(':strength',   $monster->getStrength(), \PDO::PARAM_INT);
		$request->bindValue(':resistance', $monster->getResistance(), \PDO::PARAM_INT);
		$request->bindValue(':speed', 	   $monster->getSpeed(), \PDO::PARAM_INT);
		$request->bindValue(':posture',    $monster->getPosture());
		$request->bindValue(':round', 	   $monster->getRound());
		$request->bindValue(':name', 	   $monster->getName());
		$request->bindValue(':position_x', $monster->getPosition_x(), \PDO::PARAM_INT);
		$request->bindValue(':position_y', $monster->getPosition_y(), \PDO::PARAM_INT);
		$request->bindValue(':direction',  $monster->getDirection());
		$request->bindValue(':ref', 	   $monster->getRef());

		if ($request->execute() != false) {
            $monster->setId( $this->pdo->lastInsertId() );

            return $monster;
        }
        else {
            return false;
        }
	}

	protected function update(Entity $entity)
	{
		$request = $this->pdo->prepare('UPDATE ' . $this->type . '_monster
										SET health_max = :health_max,
											health     = :health,
											strength   = :strength,
											resistance = :resistance,
											speed	   = :speed,
											posture	   = :posture,
											round 	   = :round,
											id 		   = :id,
											name       = :name,
											position_x = :position_x,
											position_y = :position_y,
											direction  = :direction,
											ref		   = :ref
										WHERE id = :id');

		$request->bindValue(':health_max', $entity->getHealth_max(), \PDO::PARAM_INT);
		$request->bindValue(':health', 	   $entity->getHealth(), \PDO::PARAM_INT);
		$request->bindValue(':strength',   $entity->getStrength(), \PDO::PARAM_INT);
		$request->bindValue(':resistance', $entity->getResistance(), \PDO::PARAM_INT);
		$request->bindValue(':speed', 	   $entity->getSpeed(), \PDO::PARAM_INT);
		$request->bindValue(':posture',    $entity->getPosture());
		$request->bindValue(':round', 	   $entity->getRound());
		$request->bindValue(':name', 	   $entity->getName());
		$request->bindValue(':position_x', $entity->getPosition_x(), \PDO::PARAM_INT);
		$request->bindValue(':position_y', $entity->getPosition_y(), \PDO::PARAM_INT);
		$request->bindValue(':direction',  $entity->getDirection());
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
		$request = $this->pdo->prepare('DELETE FROM ' . $this->type . '_monster WHERE id = :id');
        $request->bindValue(':id', $id);
        $request->execute();
	}
}