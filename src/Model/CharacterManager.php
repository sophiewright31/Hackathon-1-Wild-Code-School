<?php

namespace App\Model;

class CharacterManager extends AbstractManager
{
    public function selectAvailableOptions(): array
    {
        $match = [];
        $status = $this->pdo->query("SELECT DISTINCT status FROM lover")->fetchAll(\PDO::FETCH_COLUMN);
        $species = $this->pdo->query("SELECT DISTINCT species FROM lover")->fetchAll(\PDO::FETCH_COLUMN);
        $gender = $this->pdo->query("SELECT DISTINCT gender FROM lover")->fetchAll(\PDO::FETCH_COLUMN);
        $hair = $this->pdo->query("SELECT DISTINCT hair FROM lover")->fetchAll(\PDO::FETCH_COLUMN);
        $skills = $this->pdo->query("SELECT DISTINCT skill1 FROM lover")->fetchAll(\PDO::FETCH_COLUMN);
        $match['status'] = $status;
        $match['species'] = $species;
        $match['gender'] = $gender;
        $match['hair'] = $hair;
        $match['skill'] = $skills;
        return $match;
    }

    public function returnPerfectMatch($caracteristics)
    {
        $query = "SELECT * FROM lover 
                WHERE status = :status 
                AND species = :species
                AND gender = :gender
                AND hair = :hair
                AND skill1 = :skill1";
        $statement = $this->pdo->prepare($query);
        $statement->bindValue('status', $caracteristics['status'], \PDO::PARAM_STR);
        $statement->bindValue('species', $caracteristics['species'], \PDO::PARAM_STR);
        $statement->bindValue('gender', $caracteristics['gender'], \PDO::PARAM_STR);
        $statement->bindValue('hair', $caracteristics['hair'], \PDO::PARAM_STR);
        $statement->bindValue('skill1', $caracteristics['skill1'], \PDO::PARAM_STR);
        $statement->execute();
        return $statement->fetch();
    }

    public function returnAlternativeMatch($caracteristics)
    {
        $query = "SELECT * FROM lover 
                WHERE status = :status 
                AND species = :species
                ";
        $statement = $this->pdo->prepare($query);
        $statement->bindValue('status', $caracteristics['status'], \PDO::PARAM_STR);
        $statement->bindValue('species', $caracteristics['species'], \PDO::PARAM_STR);
        $statement->execute();
        return $statement->fetch();
    }

    public function meet()
    {
        $query = "SELECT * FROM lover JOIN quote ON quote.character_id = lover.id";
        return $this->pdo->query($query)->fetchAll();
    }
}
