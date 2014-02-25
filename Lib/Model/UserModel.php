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
			$users_list[] = new User( $user );
		}

		return $users_list;
	}

	public function select($id)
	{
		$q = $this->pdo->prepare('SELECT * 
								  FROM User
								  WHERE id = :id');

		$q->bindValue(':id', $id, \PDO::PARAM_INT);

		$q->execute();

		if (($user = $q->fetch()) != false) {
			return new User( $user );
		}
		else {
			return false;
		}
	}

	protected function insert(Entity $user)
	{
		$q = $this->pdo->prepare('INSERT INTO User
								  SET username = :username,
								  	  password = :password,
								  	  email    = :email,
								  	  salt     = :salt');

		$q->bindValue(':username', $user->getUsername());
		$q->bindValue(':password', $user->getPassword());
		$q->bindValue(':email',    $user->getEmail());
		$q->bindValue(':salt',     $user->getSalt());

		if ($q->execute() != false) {
			$user->setId( $this->pdo->lastInsertId() );
			return $user;
		}
		else {
			return false;
		}
	}

	protected function update(Entity $entity)
	{
		$q = $this->pdo->prepare('UPDATE User
								  SET username = :username,
								  	  password = :password,
								  	  email    = :email,
								  	  salt     = :salt');

		$q->bindValue(':username', $user->getUsername());
		$q->bindValue(':password', $user->getPassword());
		$q->bindValue(':email',    $user->getEmail());
		$q->bindValue(':salt',     $user->getSalt());

		return ($q->execute() != false) ? $user : false;
	}


	public function delete($id)
	{

	}

	public function getByUsername($username)
	{
		$q = $this->pdo->prepare('SELECT * 
								  FROM User
								  WHERE username = :username');

		$q->bindValue(':username', $username);

		$q->execute();

		if (($user = $q->fetch()) != false) {
			return new User( $user );
		}
		else {
			return false;
		}
	}
}