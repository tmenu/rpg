<?php

namespace Lib\Model;

use Lib\Entity\Entity;
use Lib\Entity\User;

class UserModel extends Model
{
	public function selectAll()
	{
		$q = $this->pdo->query('SELECT * FROM User');

		$users_list = array();

		foreach ($q->fetchAll() as $user)
		{
			$users_list = new User( $user );
		}

		return $users_list;
	}

	public function select($id)
	{

	}

	protected function insert(Entity $entity)
	{

	}

	protected function update(Entity $entity)
	{

	}


	public function delete($id)
	{

	}
}