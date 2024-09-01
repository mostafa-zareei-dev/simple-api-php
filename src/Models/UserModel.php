<?php

namespace App\Models;

class UserModel extends Model
{
    protected string $tableName = "users";

    public function findAll(array $params = []): array | false
    {
        $query = "SELECT * FROM $this->tableName";
        $this->db->query($query, $params);

        return $this->db->findAll();
    }

    public function create(array $params): bool
    {
        $query = "INSERT INTO $this->tableName (name, email, password) VALUES(:name, :email, :password)";
        $this->db->query($query, $params);

        return (bool)$this->db->rowCount();
    }

    public function update(int $id, array $params): bool
    {
        $query = "UPDATE $this->tableName SET name=:name, email=:email WHERE id=:id";
        $params['id'] = $id;
        $this->db->query($query, $params);

        return (bool)$this->db->rowCount();
    }

    public function delete(int $id): bool
    {
        $query = "DELETE FROM $this->tableName WHERE id=:id";
        $params = [];
        $params['id'] = $id;
        $this->db->query($query, $params);

        return (bool)$this->db->rowCount();
    }
}
