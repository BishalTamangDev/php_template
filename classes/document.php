<?php

require_once __DIR__ . '/../classes/connection.php';
class Document extends Database
{
    private $id;
    private $name;

    private $table = "document_tb";

    // constructor
    public function __construct()
    {
        $id = 0;
        $name = "";
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

    // setter
    public function setId($id)
    {
        $this->id = $id;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    // upload
    public function upload()
    {
        $query = "INSERT INTO $this->table (`name`) VALUES (:name)";

        $stmt = $this->connect()->prepare($query);

        try {
            return $stmt->execute([":name" => $this->name]);
        } catch (PDOException $e) {
            return false;
        }
    }

    // delete
    public function delete($id)
    {
        // get filename
        $query = "SELECT name FROM $this->table WHERE `id` = :id";
        $stmt = $this->connect()->prepare($query);

        try {
            $stmt->execute([":id" => $id]);

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            $this->name = $row['name'];
        } catch (PDOException $e) {
            return false;
        }

        // delete from databse
        $query = "DELETE FROM $this->table WHERE `id` = :id";

        $stmt = $this->connect()->prepare($query);

        try {
            $stmt->execute([":id" => $id]);
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    // fetch
    public function fetch($id)
    {
        $query = "SELECT * FROM $this->table WHERE $id = :id";

        $stmt = $this->connect()->prepare($query);

        try {
            $stmt->execute([":id" => $id]);
            $file = $stmt->fetch();
            $this->id = $id;
            $this->name = $file["name"];
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    // fetch app document
    public function fetchAll()
    {
        $documents = [];

        $query = "SELECT * FROM $this->table";

        $stmt = $this->connect()->prepare($query);

        try {
            $stmt->execute();
            $documents = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
        }

        return $documents;
    }
}
