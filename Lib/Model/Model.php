<?php

namespace Lib\Model;

use Lib\Entity\Entity;

abstract class Model
{
	protected $pdo = null;

	public function __construct(\PDO $pdo)
	{
		$this->pdo = $pdo;
	}

	abstract public function selectAll();
	abstract public function select($id);

	public function save(Entity $entity)
	{
		if ($entity->isNew()) {
			return $this->insert($entity);
		}
		else {
			return $this->update($entity);
		}
	}

	abstract protected function insert(Entity $entity);
	abstract protected function update(Entity $entity);

	abstract public function delete($id);
}