<?php

namespace Lib\Model;

use Lib\Router;
use Lib\Utils;
use Lib\Manager;

use Lib\Entity\Entity;
use Lib\Entity\Map_monster;

abstract class Map_monsterModel extends Model
{
	public function selectAll()
	{
		die('not develop yet');

		$request = $this->pdo->prepare('SELECT * FROM ' . $this->type . '_map_monster');
        $request->execute();

        $results = $request->fetchAll();

        $map_monster_list = array();

        foreach ($request->fetchAll() as $map_monster)
        {
            $map_monster_list[] = new Map_monster($map_monster);
        }

        return $map_monster_list;
	}

	public function select($id)
	{
		die('not develop yet');
	}

	public function selectByMap($ref_map)
	{
		// Lecture des monstres d'une map particulière
		$request = $this->pdo->prepare('SELECT * FROM ' . $this->type . '_map_monster WHERE ref_map = :ref_map');
        $request->bindValue(':ref_map', $ref_map, \PDO::PARAM_INT);
        $request->execute();

        // Conversion en objet
        $map_monsters = array();

        foreach ($request->fetchAll() as $map_monster)
        {
        	$map_monsters[] = new Map_monster( $map_monster );
        }

        return $map_monsters;
	}

	protected function insert(Entity $map_monster)
	{
		$request = $this->pdo->prepare('INSERT INTO ' . $this->type . '_map_monster
										SET ref_map     = :ref_map,
											ref_monster = :ref_monster,
											position_x  = :position_x,
											position_y  = :position_y');

		$request->bindValue(':ref_map',     $map_monster->getRef_map(),     \PDO::PARAM_INT);
		$request->bindValue(':ref_monster', $map_monster->getRef_monster(), \PDO::PARAM_INT);
		$request->bindValue(':position_x',  $map_monster->getPosition_x(),  \PDO::PARAM_INT);
		$request->bindValue(':position_y',  $map_monster->getPosition_y(),  \PDO::PARAM_INT);

		$request->execute();
	}

	protected function update(Entity $entity)
	{
		die('not develop yet');
	}

	public function delete($id)
	{
		$request = $this->pdo->prepare('DELETE FROM ' . $this->type . '_map_monster WHERE id = :id');
        $request->bindValue(':id', $id);
        $request->execute();
	}

	public function deleteByMonster($ref_monster)
	{
		$request = $this->pdo->prepare('DELETE FROM ' . $this->type . '_map_monster WHERE ref_monster = :ref_monster');
        $request->bindValue(':ref_monster', $ref_monster);
        $request->execute();
	}
}