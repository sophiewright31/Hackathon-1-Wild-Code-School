<?php

namespace App\Model;

class CharacterManager extends AbstractManager
{
    public const TABLE = 'lover';
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
                WHERE  species  LIKE :species";


        $statement = $this->pdo->prepare($query);
        $statement->bindValue('species', $caracteristics['species'] . "%", \PDO::PARAM_STR);
        $statement->execute();

        return ( $statement->fetch());
    }

    public function insertLocation($idCharacter, $divIdLocation)
    {
        $query = "UPDATE lover SET location = :location WHERE id = :id";
        $statement = $this->pdo->prepare($query);
        $statement->bindValue('location', $divIdLocation, \PDO::PARAM_STR);
        $statement->bindValue('id', $idCharacter, \PDO::PARAM_STR);
        $statement->execute();
    }

    public function getcaracteisticsById($matchId)
    {
        $query = "SELECT  species, skill1, hair,  status FROM lover WHERE id =" . $matchId;
        $statement = $this->pdo->query($query);
        return $statement->fetchAll();
    }
    public function potentialMatchingLover($caracteristics)
    {
        $query = ("SELECT  l.id, m.xcoord, m.ycoord, l.status, l.species,  l.hair, l.skill1  FROM lover l
                JOIN mapcell m ON l.location = m.cell_nb
                WHERE l.status = :status
                OR l.species = :species
                OR l.hair = :hair
                OR l.skill1 = :skill1");
        $statement = $this->pdo->prepare($query);
        $statement->bindValue('status', $caracteristics[0]['status'], \PDO::PARAM_STR);
        $statement->bindValue('species', $caracteristics[0]['species'], \PDO::PARAM_STR);
//        $statement->bindValue('gender', $caracteristics[0]['gender'], \PDO::PARAM_STR);
        $statement->bindValue('hair', $caracteristics[0]['hair'], \PDO::PARAM_STR);
        $statement->bindValue('skill1', $caracteristics[0]['skill1'], \PDO::PARAM_STR);
        $statement->execute();
        return $statement->fetchAll();
    }
    public function getLoversByPosition($cellId)
    {
        $query = ("SELECT * FROM lover LEFT JOIN quote ON quote.character_id = lover.id  
                  WHERE location = " . $cellId);
        $statement = $this->pdo->query($query);
        return $statement->fetchAll();
    }

    public function getBackground($cellId)
    {
        $query = ('SELECT * FROM mapcell WHERE cell_nb = ' . $cellId);
        $statement = $this->pdo->query($query);
        return $statement->fetchAll();
    }

    public function meet()
    {
        $query = "SELECT * FROM lover JOIN quote ON quote.character_id = lover.id";
        return $this->pdo->query($query)->fetchAll();
    }
}
