<?php
require_once __DIR__ . '/connection.php';
class Person extends Database
{
    private $id;
    private $name;
    private $gender;
    private $dateOfBirth;
    private $height;
    private $isFrank;
    private $mobileBrand;
    private $description;

    public function __construct()
    {
        $this->id = 0;
        $this->name = "";
        $this->gender = "";
        $this->dateOfBirth = 0;
        $this->height = 0.0;
        $this->isFrank = 0;
        $this->mobileBrand = "";
        $this->description = "";
    }

    // set
    public function set($id, $name, $gender, $dateOfBirth, $height, $isFrank, $mobileBrand, $description)
    {
        $this->id = $id;
        $this->name = $name;
        $this->gender = $gender;
        $this->dateOfBirth = $dateOfBirth;
        $this->height = $height;
        $this->isFrank = $isFrank;
        $this->mobileBrand = $mobileBrand;
        $this->description = $description;
    }

    // setter

    // getter
    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getGender()
    {
        return $this->gender;
    }

    public function getDateOfBirth()
    {
        return $this->dateOfBirth;
    }

    public function getHeight()
    {
        return $this->height;
    }

    public function getIsFrank()
    {
        return $this->isFrank;
    }

    public function getMobileBrand()
    {
        return $this->mobileBrand;
    }

    public function getDescription()
    {
        return $this->description;
    }

    // validity check
    public function isValid()
    {
        return ($this->name == "" || $this->gender == "" || $this->dateOfBirth == 0 || $this->height == 0.0 || $this->mobileBrand == "" || $this->description == "") ? false : true;
    }

    // insert person detail in database
    public function insertPerson()
    {
        $query = "INSERT INTO person_tb (`name`, `gender`, `date_of_birth`, `height`, `is_frank`, `mobile_brand`, `description`) VALUES (:name, :gender, :dateOfBirth, :height, :isFrank, :mobileBrand, :description);";

        $stmt = $this->connect()->prepare($query);

        try {
            return $stmt->execute([":name" => $this->name, ":gender" => $this->gender, ":dateOfBirth" => $this->dateOfBirth, "height" => $this->height, "isFrank" => $this->isFrank, "mobileBrand" => $this->mobileBrand, "description" => $this->description]);
        } catch (PDOException $e) {
            return false;
        }
    }

    // update detail
    public function update($id)
    {
        $query = "UPDATE person_tb set `name` = :name, `gender` = :gender, `date_of_birth` = :dateOfBirth, `height` = :height, `is_frank` = :isFrank, `mobile_brand` = :mobileBrand, `description` = :description WHERE `id` = :id";

        $stmt = $this->connect()->prepare($query);

        try {
            return $stmt->execute([":id" => $id, ":name" => $this->name, ":gender" => $this->gender, ":dateOfBirth" => $this->dateOfBirth, ":height" => $this->height, ":isFrank" => $this->isFrank, ":mobileBrand" => $this->mobileBrand, ":description" => $this->description]);
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

                $this->set($id, $data['name'], $data['gender'], $data['date_of_birth'], $data['height'], $data['is_frank'], $data['mobile_brand'], $data['description']);

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
