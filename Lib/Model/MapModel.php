<?php

namespace Lib\Model;

use Lib\Router;
use Lib\Utils;
use Lib\Manager;

use Lib\Entity\Entity;
use Lib\Entity\Map;
use Lib\Entity\Map_monster;
use Lib\Entity\Monster;

abstract class MapModel extends Model
{
	public function selectAll()
	{
        die('not develop yet');
        
        // Lecture des maps
		$request = $this->pdo->prepare('SELECT * FROM ' . $this->type . '_map');
        $request->execute();

        $results = $request->fetchAll();

        // Conversion en objet
        $maps_list = array();

        foreach ($results as $result)
        {
            $map = new Map($result);

            $maps_list[] = $map;
        }

        return $maps_list;
	}

	public function select($id)
	{
        // Lecture du la map
		$request = $this->pdo->prepare('SELECT * FROM ' . $this->type . '_map WHERE id = :id');
        $request->bindValue(':id', $id);
        $request->execute();

        // Si elle existe
        if (($result = $request->fetch()) != false)
        {
            return new Map($result);
        }
        else
        {
            return false;
        }
	}

	protected function insert(Entity $map)
	{	
		$q = $this->pdo->prepare('INSERT INTO ' . $this->type . '_map
                                  SET name        = :name,
                                      size_height = :size_height,
                                      size_width  = :size_width,
                                      visible_x   = :visible_x,
                                      visible_y   = :visible_y,
                                      origin_x    = :origin_x,
                                      origin_y    = :origin_y,
                                      map         = :map');

        $q->bindValue(':name',        $map->getName());
        $q->bindValue(':size_height', $map->getSize_height(), \PDO::PARAM_INT);
        $q->bindValue(':size_width',  $map->getSize_width(),  \PDO::PARAM_INT);
        $q->bindValue(':visible_x',   $map->getVisible_x(),   \PDO::PARAM_INT);
        $q->bindValue(':visible_y',   $map->getVisible_y(),   \PDO::PARAM_INT);
        $q->bindValue(':origin_x',    $map->getOrigin_x(),    \PDO::PARAM_INT);
        $q->bindValue(':origin_y',    $map->getOrigin_y(),    \PDO::PARAM_INT);
        $q->bindValue(':map',         serialize($map->getMap()));

        if ($q->execute() != false) {
            $map->setId( $this->pdo->lastInsertId() );

            foreach ($map->getMonsters() as $monster)
            {
                // Enregsitrement du monstre
                $monster = Manager::getManagerOf('playing_monster')->save( $monster );

                // Création de la liaison map/monster
                $map_monster = new Map_monster();

                $map_monster->setRef_map( $map->getId() );
                $map_monster->setRef_monster( $monster->getId() );
                $map_monster->setPosition_x( $monster->getPosition_x() );
                $map_monster->setPosition_y( $monster->getPosition_y() );

                // Enregistrement de la liaison
                Manager::getManagerOf('playing_map_monster')->save( $map_monster );
            }

            return $map;
        }
        else {
            return false;
        }
	}

	protected function update(Entity $entity)
	{
		die('not develop yet');
	}

	public function delete($id)
	{
		$request = $this->pdo->prepare('DELETE FROM ' . $this->type . '_map WHERE id = :id');
        $request->bindValue(':id', $id);
        $request->execute();
	}
}