<?php
require_once __DIR__ . '/connection.php';
class Person extends Database
{
    private $id;
    private $name;
    private $weight;
    private $appetite;

    public function __construct()
    {
        $this->id = 0;
        $this->name = "";
        $this->weight = 0.0;
        $this->appetite = false;
    }

    // setter
    public function setId($id)
    {
        $this->id = $id;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function setWeight($weight)
    {
        $this->weight = $weight;
    }

    public function setAppetite($appetite)
    {
        $this->appetite = $appetite;
    }

    // getter
    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getWeight()
    {
        return $this->weight;
    }

    public function getAppetite()
    {
        return $this->appetite;
    }

    // validity check
    public function isValid()
    {
        return ($this->name == "" || $this->weight == 0) ? false : true;
    }

    // insert person detail in database
    public function insertPerson()
    {
        $query = "INSERT INTO person_tb (`name`, `weight`, `appetite`) VALUES (:name, :weight, :appetite);";

        $stmt = $this->connect()->prepare($query);

        try {
            return $stmt->execute([":name" => $this->name, ":weight" => $this->weight, ":appetite" => $this->appetite]);
        } catch (PDOException $e) {
            return false;
        }
    }

    // update detail
    public function update($id)
    {
        $query = "UPDATE person_tb set `name` = :name, `weight` = :weight, `appetite` = :appetite WHERE `id` = :id";

        $stmt = $this->connect()->prepare($query);

        try {
            return $stmt->execute([":id" => $id, ":name" => $this->name, ":weight"=> $this->weight, ":appetite" => $this->appetite]);
        } catch (PDOException $e) {
            return false;
        }
    }

    // delete person
    public function deletePerson($id)
    {
        $query = "DELETE FROM person_tb WHERE `id` = :id";

        $stmt = $this->connect()->prepare($query);

        try {
            return $stmt->execute([":id" => $id]);
        } catch (PDOException $e) {
            return false;
        }
    }

    // fetch all person
    public function fetchAll()
    {
        $query = "SELECT * FROM person_tb";
        $stmt = $this->connect()->prepare($query);

        try {
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            }
        } catch (PDOException $e) {
            return [];
        }

        return [];
    }

    // fetch person by id
    public function fetch($id)
    {
        $query = "SELECT * FROM person_tb WHERE `id` = :id";
        $stmt = $this->connect()->prepare($query);

        try {
            $stmt->execute(['id' => $id]);
            if ($stmt->rowCount() == 1) {
                $data = $stmt->fetch(PDO::FETCH_ASSOC);

                $this->setId($id);
                $this->setName($data['name']);
                $this->setWeight($data['weight']);
                $this->setAppetite($data['appetite']);

                return true;
            }
        } catch (PDOException $e) {
        }

        return false;
    }

    // search
    public function search($searchContent)
    {
        $searchContent = "%$searchContent%";
        $data = [];

        $query = "SELECT * FROM person_tb WHERE `name` LIKE :searchContent";
        $stmt = $this->connect()->prepare($query);
        
        try {
            $stmt->execute([":searchContent" => $searchContent]);
            
            if ($stmt->rowCount() > 0) {
                $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            } 
        } catch (PDOException $e) {
            echo "5";
        }
        return $data;
    }
}
