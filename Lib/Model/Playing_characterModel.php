<?php

namespace Lib\Model;

use Lib\Router;
use Lib\Utils;
use Lib\Manager;
use Lib\Entity\Entity;
use Lib\Entity\Playing_character;

class Playing_characterModel extends Model
{
	public function selectAll()
	{
		$request = $this->pdo->prepare('SELECT * FROM Playing_character');
        $request->execute();

        $results = $request->fetchAll();

        $character_list = array();

        foreach ($results as $result)
        {
            $character_list[] = new Playing_character($result);
        }

        return $character_list;
	}

	public function select($id)
	{
		$request = $this->pdo->prepare('SELECT * FROM Playing_character WHERE id = :id');
        $request->bindValue(':id', $id);
        $request->execute();

        if(($result = $request->fetch()) != false)
        {
            return new Playing_character($result);
        }
        else
        {
            return false;
        }
	}

	protected function insert(Entity $entity)
	{	
		$request = $this->pdo->prepare('INSERT INTO Playing_character
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

		$request->bindValue(':health_max', $entity->getHealthMax(), \PDO::PARAM_INT);
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

		$request->execute();
	}

	protected function update(Entity $entity)
	{
		$request = $this->pdo->prepare('UPDATE Playing_character
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

		$request->bindValue(':health_max', $entity->getHealthMax(), \PDO::PARAM_INT);
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


		$request->execute();
	}

	public function delete($id)
	{
		$request = $this->pdo->prepare('DELETE FROM Playing_character WHERE id = :id');
        $request->bindValue(':id', $id);
        $request->execute();
	}
}