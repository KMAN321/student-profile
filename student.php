<?php
include_once("db.php"); // Include the file with the Database class

class Student
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function create($data)
    {
        try {
            // Prepare the SQL INSERT statement
            $sql = "INSERT INTO students(student_number, first_name, middle_name, last_name, gender, birthday) VALUES(:student_number, :first_name, :middle_name, :last_name, :gender, :birthday);";
            $stmt = $this->db->getConnection()->prepare($sql);

            // Bind values to placeholders
            $stmt->bindParam(':student_number', $data['student_number']);
            $stmt->bindParam(':first_name', $data['first_name']);
            $stmt->bindParam(':middle_name', $data['middle_name']);
            $stmt->bindParam(':last_name', $data['last_name']);
            $stmt->bindParam(':gender', $data['gender']);
            $stmt->bindParam(':birthday', $data['birthday']);

            // Execute the INSERT query
            $stmt->execute();

            // Check if the insert was successful

            if ($stmt->rowCount() > 0) {
                return $this->db->getConnection()->lastInsertId();
            }
        } catch (PDOException $e) {
            // Handle any potential errors here
            echo "Error: " . $e->getMessage();
            throw $e; // Re-throw the exception for higher-level handling
        }
    }

    public function read($id)
    {
        try {
            $connection = $this->db->getConnection();

            $sql = "SELECT * FROM students WHERE id = :id";
            $stmt = $connection->prepare($sql);
            $stmt->bindValue(':id', $id);
            $stmt->execute();

            // Fetch the student data as an associative array
            $studentData = $stmt->fetch(PDO::FETCH_ASSOC);


            return $studentData;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            throw $e; // Re-throw the exception for higher-level handling
        }
    }

    public function update($id, $data)
    {
        try {
            $this->db->getConnection()->beginTransaction();

            // Update the students and student_details tables
            $sql = "
        UPDATE students
        INNER JOIN student_details ON students.id = student_details.student_id
        SET
            students.student_number = :student_number,
            students.first_name = :first_name,
            students.middle_name = :middle_name,
            students.last_name = :last_name,
            students.gender = :gender,
            students.birthday = :birthday,
            student_details.contact_number = :contact_number,
            student_details.street = :street,
            student_details.town_city = :town_city,
            student_details.province = :province,
            student_details.zip_code = :zip_code
        WHERE students.id = :id
    ";

            $stmt = $this->db->getConnection()->prepare($sql);
            // Bind parameters
            $stmt->bindValue(':id', $id);
            $stmt->bindValue(':student_number', $data['student_number']);
            $stmt->bindValue(':first_name', $data['first_name']);
            $stmt->bindValue(':middle_name', $data['middle_name']);
            $stmt->bindValue(':last_name', $data['last_name']);
            $stmt->bindValue(':gender', $data['gender']);
            $stmt->bindValue(':birthday', $data['birthday']);
            $stmt->bindValue(':contact_number', $data['contact_number']);
            $stmt->bindValue(':street', $data['street']);
            $stmt->bindValue(':town_city', $data['town_city']);
            $stmt->bindValue(':province', $data['province']);
            $stmt->bindValue(':zip_code', $data['zip_code']);

            // Execute the query
            $stmt->execute();

            $this->db->getConnection()->commit();

            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            $this->db->getConnection()->rollBack();
            echo "Error: " . $e->getMessage();
            throw $e; // Re-throw the exception for higher-level handling
        }
    }






    public function delete($id)
    {
        try {
            $sql = "DELETE FROM students WHERE id = :id";
            $stmt = $this->db->getConnection()->prepare($sql);
            $stmt->bindValue(':id', $id);
            $stmt->execute();

            // Check if any rows were affected (record deleted)
            if ($stmt->rowCount() > 0) {
                return true; // Record deleted successfully
            } else {
                return false; // No records were deleted (student_id not found)
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            throw $e; // Re-throw the exception for higher-level handling
        }
    }

    public function displayAll()
    {
        try {
            $sql = "SELECT
                        students.id AS student_id,
                        students.student_number,
                        students.first_name,
                        students.last_name,
                        students.middle_name,
                        students.gender,
                        students.birthday,
                        student_details.contact_number,
                        student_details.street,
                        town_city.name AS town_city,
                        province.name AS province,
                        student_details.zip_code
                    FROM
                        students
                    JOIN
                        student_details ON students.id = student_details.student_id
                    JOIN
                        town_city ON student_details.town_city = town_city.id
                    JOIN
                        province ON student_details.province = province.id
                    ORDER BY
                        students.id DESC
                    LIMIT 10;";

            $stmt = $this->db->getConnection()->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } catch (PDOException $e) {
            // Handle any potential errors here
            echo "Error: " . $e->getMessage();
            throw $e; // Re-throw the exception for higher-level handling
        }
    }
}
