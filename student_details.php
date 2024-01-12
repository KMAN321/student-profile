<?php
include_once("db.php"); // Include the file with the Database class

class StudentDetails {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    // Create a student detail entry and link it to a student
    public function create($data) {
        try {
            // Prepare the SQL INSERT statement
            $sql = "INSERT INTO student_details(student_id, contact_number, street, zip_code, town_city, province) VALUES(:student_id, :contact_number, :street, :zip_code, :town_city,:province);";
            $stmt = $this->db->getConnection()->prepare($sql);

            // Bind values to placeholders
            $stmt->bindParam(':student_id', $data['student_id']);
            $stmt->bindParam(':contact_number', $data['contact_number']);
            $stmt->bindParam(':street', $data['street']);
            $stmt->bindParam(':zip_code', $data['zip_code']);
            $stmt->bindParam(':town_city', $data['town_city']);
            $stmt->bindParam(':province', $data['province']);

            // Execute the INSERT query
            $stmt->execute();

            // Check if the insert was successful
            return $stmt->rowCount() > 0;

        } catch (PDOException $e) {
            // Handle any potential errors here
            echo "Error: " . $e->getMessage();
            throw $e; // Re-throw the exception for higher-level handling
        }
        
    }

    // Read a student detail entry
    public function read($id) {
        try {
            $connection = $this->db->getConnection();

            $sql = "SELECT * FROM student_details WHERE student_id = :student_id";
            $stmt = $connection->prepare($sql);
            $stmt->bindParam(':student_id', $id);
            $stmt->execute();

            // Fetch the student data as an associative array
            $studentData = $stmt->fetch(PDO::FETCH_ASSOC);
            

            return $studentData;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            throw $e; // Re-throw the exception for higher-level handling
        }
    }

    // Delete a student detail entry
    public function delete($id) {
        try {
            $sql = "DELETE FROM student_details WHERE student_id = :student_id";
            $stmt = $this->db->getConnection()->prepare($sql);
            $stmt->bindValue(':student_id', $id);
            $stmt->execute();

            // Check if the delete was successful
            return $stmt->rowCount() > 0;

        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            throw $e; // Re-throw the exception for higher-level handling
        }
    }

    // Get all student detail entries
    public function getAll() {
        try {
            $sql = "SELECT * FROM student_details";
            $stmt = $this->db->getConnection()->prepare($sql);
            $stmt->execute();

            // Fetch all the rows as an associative array
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $results;

        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            throw $e; // Re-throw the exception for higher-level handling
        }
    }
}

?>