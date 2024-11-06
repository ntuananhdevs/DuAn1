
<?php
class Category
{
    public $conn;

    public function __construct()
    {
        $this->conn = connectDB();
    }

    public function get_categories()
    {
        try {
            $sql = "SELECT 
    c.id, 
    c.category_name, 
    c.description, 
    COUNT(p.id) AS product_count
FROM 
    category c
LEFT JOIN 
    products p 
ON 
    c.id = p.category_id
GROUP BY 
    c.id, c.category_name, c.description;
";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }
    public function categorybyid($id)
    {
        try {
            $sql = "SELECT * FROM category WHERE id = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$id]);
            return $stmt->fetch();
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }
    public function add($category_name, $description)
    {
        try {
            $sql = "INSERT INTO category (category_name, description) VALUES (:category_name, :description)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':category_name', $category_name);
            $stmt->bindParam(':description', $description);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }

    public function update($id, $category_name, $description)
    {
        try {
            $sql = "UPDATE category SET category_name = :category_name, description = :description WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':category_name', $category_name);
            $stmt->bindParam(':description', $description);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }
    


    public function delete($id)
    {
        try {
            $sql = "DELETE FROM category WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id', $id);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }
    public function getCategorybyID($id)
    {
        try {
            $sql = "SELECT * FROM category WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }
}
