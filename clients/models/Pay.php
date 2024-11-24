<?php 
class Pay {

    public $conn;

    public function __construct() {
        $this->conn = connectDB();
    }
    
    public function get_Provinces(){
        $query = "SELECT code, name FROM provinces";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getDistrictsByProvince($provinceCode) {
        $query = "SELECT code, name FROM districts WHERE province_code = :province_code";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':province_code', $provinceCode);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getWardsByDistrict($districtCode) {
        $query = "SELECT code, name FROM wards WHERE district_code = :district_code";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':district_code', $districtCode);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    

}