<?php

namespace Lib\Model;

use Lib\Router;
use Lib\Utils;
use Lib\Manager;

use Lib\Entity\Entity,
	Lib\Entity\Game;

class GameModel extends Model
{
	public function selectAll()
	{
		die('not develop yet');

		$request = $this->pdo->prepare('SELECT * FROM Game');
        $request->execute();

        $results = $request->fetchAll();

        $game_list = array();

        foreach ($results as $result)
        {
            $game_list[] = new Game($result);
        }

        return $character_list;
	}

	public function select($id)
	{
		// Lecture de la partie demandée
		$request = $this->pdo->prepare('SELECT * FROM Game WHERE id = :id');
        $request->bindValue(':id', $id);
        $request->execute();

        if (($result = $request->fetch()) != false)
        {
            return new Game($result);
        }
        else
        {
            return false;
        }
	}

	public function selectByUser($user_id)
	{
		// Lecture de la partie demandée
		$request = $this->pdo->prepare('SELECT * FROM Game WHERE ref_user = :ref_user');
        $request->bindValue(':ref_user', $user_id, \PDO::PARAM_INT);
        $request->execute();

        $games_list = array();

        foreach ($request->fetchAll() as $game)
        {
            $games_list[] = new Game($game);
        }

		return $games_list;
	}

	protected function insert(Entity $entity)
	{
		$q = $this->pdo->prepare('INSERT INTO Game
								  SET ref_user      = :ref_user,
								      ref_map       = :ref_map,
								      ref_character = :ref_character,
								      ref_initial_map       = :ref_initial_map,
								      ref_initial_character = :ref_initial_character');

		$q->bindValue(':ref_user',      $entity->getRef_user(),      \PDO::PARAM_INT);
		$q->bindValue(':ref_map',       $entity->getRef_map(),       \PDO::PARAM_INT);
		$q->bindValue(':ref_character', $entity->getRef_character(), \PDO::PARAM_INT);
		$q->bindValue(':ref_initial_map',       $entity->getRef_initial_map(),       \PDO::PARAM_INT);
		$q->bindValue(':ref_initial_character', $entity->getRef_initial_character(), \PDO::PARAM_INT);

		if ($q->execute() != false) {
			$entity->setId( $this->pdo->lastInsertId() );
			return $entity;
		}
		else {
			return false;
		}
	}

	protected function update(Entity $entity)
	{
		$q = $this->pdo->prepare('UPDATE Game
								  SET ref_user      = :ref_user,
								      ref_map       = :ref_map,
								      ref_character = :ref_character,
								      ref_initial_map       = :ref_initial_map,
								      ref_initial_character = :ref_initial_character
								   WHERE id = :id');

		$q->bindValue(':ref_user',      $entity->getRef_user(),      \PDO::PARAM_INT);
		$q->bindValue(':ref_map',       $entity->getRef_map(),       \PDO::PARAM_INT);
		$q->bindValue(':ref_character', $entity->getRef_character(), \PDO::PARAM_INT);
		$q->bindValue(':ref_initial_map',       $entity->getRef_initial_map(),       \PDO::PARAM_INT);
		$q->bindValue(':ref_initial_character', $entity->getRef_initial_character(), \PDO::PARAM_INT);
		$q->bindValue(':id', $entity->getId(), \PDO::PARAM_INT);

		if ($q->execute() != false) {
			return $entity;
		}
		else {
			return false;
		}
	}

	public function delete($id)
	{
		$request = $this->pdo->prepare('DELETE FROM Game WHERE id = :id');
        $request->bindValue(':id', $id);
        $request->execute();
	}
}