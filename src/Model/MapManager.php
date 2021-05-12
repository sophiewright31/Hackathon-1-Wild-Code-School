<?php

namespace App\Model;

class MapManager extends AbstractManager
{
    public function getAllLoversWithCoordonates()
    {
        $query = "SELECT m.xcoord, m.ycoord, l.name, l.status, l.species, l.gender, l.hair ,l.skill1 FROM lover l
                RIGHT JOIN mapcell m ON l.location = m.cell_nb ";
        $statement = $this->pdo->query($query);
    }

    public function getCoordonates($divIdLocation)
    {
        $query = "SELECT xcoord, ycoord FROM mapcell WHERE cell_nb = " . $divIdLocation;
        $statement = $this->pdo->query($query);
        return $statement->fetch();
    }

    public function getDivIdByCoordinates(int $x, int $y)
    {
        $query = "SELECT cell_nb FROM mapcell WHERE xcoord = " . $x . ' AND ycoord = ' . $y;
        $statement = $this->pdo->query($query);
        return $statement->fetch(\PDO::FETCH_COLUMN);
    }

    public function getLoversBycoordonates($x, $y)
    {
        $query = "SELECT * FROM lover l 
         RIGHT JOIN mapcell m ON l.location = m.cell_nb
         WHERE m.xcoord=" . $x . " AND m.ycoord = " . $y;
        $statement = $this->pdo->query($query);
        return $statement->fetchAll();
    }

    public function getAreabyLoverId($id)
    {
        $query = "SELECT area_name FROM mapcell m 
                    JOIN lover l ON l.location = m.cell_nb 
                    WHERE l.id =  " . $id;
        $statement = $this->pdo->query($query);
        return $statement->fetch(\PDO::FETCH_COLUMN);
    }
}
