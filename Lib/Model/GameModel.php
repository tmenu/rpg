<?php

namespace Lib\Model;

use Lib\Router;
use Lib\Utils;
use Lib\Manager;
use Lib\Entity\Entity;

class GameModel extends Model
{
	public function selectAll()
	{
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
		$request = $this->pdo->prepare('SELECT * FROM Game WHERE id = :id');
        $request->bindValue(':id', $id);
        $request->execute();

        if(($result = $request->fetch()) != false)
        {
            return new Game($result);
        }
        else
        {
            return false;
        }
	}

	protected function insert(Entity $entity)
	{	
		
	}

	protected function update(Entity $entity)
	{
		
	}

	public function delete($id)
	{
		$request = $this->pdo->prepare('DELETE FROM Game WHERE id = :id');
        $request->bindValue(':id', $id);
        $request->execute();
	}
}