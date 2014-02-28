<?php

namespace Lib\Model;

use Lib\Entity\Map;

class Initial_mapModel extends MapModel
{
	protected $type = 'Initial';

	public function selectLevelUp($id)
	{
		// Lecture du la map
		$request = $this->pdo->prepare('SELECT * FROM ' . $this->type . '_map WHERE id > :id');
		$request->bindValue(':id', $id);
		$request->execute();

		// Si elle existe
		if (($result = $request->fetch()) != false)
		{
			$map = new Map($result);

			$map->setMap( unserialize($result['map']) );

			return $map;
		}
		else
		{
			return $request;
		}
	}
}