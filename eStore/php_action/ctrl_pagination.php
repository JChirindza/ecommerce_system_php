<?php
class Pagination {

    private $conn;

    function __construct() {
        $this->conn = $this->getConnection();
    }

    public function getConnection() {
        $localhost = "localhost";
        $username = "root";
        $password = "";
        $dbname = "loja";

        // db connection
        $connect = new mysqli($localhost, $username, $password, $dbname);
        $conn = $connect;
        return $conn;
    }

    public function select($sql, $paramType = "", $paramArray = array()) {
        $stmt = $this->conn->prepare($sql);

        if (!empty($paramType) && !empty($paramArray)) {
            $this->bindQueryParams($stmt, $paramType, $paramArray);
        }

        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $resultset[] = $row;
            }
        }

        if (! empty($resultset)) {
            return $resultset;

        }
    }

    public function bindQueryParams($stmt, $paramType, $paramArray = array()) {
        $paramValueReference[] = & $paramType;
        for ($i = 0; $i < count($paramArray); $i ++) {
            $paramValueReference[] = & $paramArray[$i];
        }
        call_user_func_array(array(
            $stmt,
            'bind_param'
        ), $paramValueReference);
    }

    public function getRecordCount($sql) {
        $query = $this->conn->query($sql);
        $recordCount = $query->num_rows;

        return $recordCount;
    }

    public function getPage($limit, $query) {
        // adding limits to select query
        // $limit = 8;
        // Look for a GET variable page if not found default is 1.
        $pn = 1;
        if (isset($_POST["page"]) && !empty($_POST['page'])) {
            $pn = $_POST['page'];
        }

        $startFrom = ($pn - 1) * $limit;

        $query .= ' LIMIT ? , ?';
        $paramType = 'ii';
        $paramValue = array(
            $startFrom,
            $limit
        );
        $result = $this->select($query, $paramType, $paramValue);
        return $result;
    }

    public function getAllRecords($query) {
        // $query = 'SELECT product.product_id, product.product_name, product.rate, product.product_image, brands.brand_name FROM product INNER JOIN brands ON product.brand_id = brands.brand_id WHERE product.status = 1 ORDER BY product_id DESC';

        $totalRecords = $this->getRecordCount($query);
        return $totalRecords;
    }
}
?>


