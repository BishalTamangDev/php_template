<?php

require_once __DIR__ . '/../classes/connection.php';

class Gallery extends Database
{
    public $id;
    public $filename;

    private $table = "image_tb";

    // constructor
    public function __construct()
    {
        $this->id = 0;
        $this->filename = 0;
    }

    // setter
    public function setId($id)
    {
        $this->id = $id;
    }

    public function setFilename($filename)
    {
        $this->filename = $filename;
    }

    // upload
    public function upload()
    {
        $query = "INSERT INTO $this->table (`filename`) VALUES (:filename)";

        $stmt = $this->connect()->prepare($query);

        $stmt->bindParam(":filename", $this->filename);

        try {
            return $stmt->execute();
        } catch (PDOException $e) {
            // return "Database error: " . $e->getMessage();
            return "An internal error occurred!";
        }
    }

    // download
    public function fetchAll()
    {
        $query = "SELECT * FROM $this->table";

        $stmt = $this->connect()->prepare($query);

        try {
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
        }
        return [];
    }

    // delete
    public function delete($id)
    {
        $filename = "";
        $status = false;

        // getting filename :: purpose -> delete file
        $query = "SELECT `filename` FROM $this->table WHERE `id` = :id";
        $stmt = $this->connect()->prepare($query);
        $stmt->bindParam(":id", $id);

        if($stmt->execute()) {
            $data = $stmt->fetch(PDO::FETCH_ASSOC);
            $filename = $data['filename'];
        }

        if($filename != "") {
            $query = "DELETE FROM $this->table WHERE `id` = :id";
            $stmt = $this->connect()->prepare($query);
            $stmt->bindParam(":id", $id);
            
            if($stmt->execute()) {
                if(unlink("../uploads/images/$filename")) {
                    $status = true;
                }
            }
        }

        return $status;
    }
}
