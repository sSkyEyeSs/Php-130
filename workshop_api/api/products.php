<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type");

include_once "../config/database.php";

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {

    // =========================
    // GET (อ่านข้อมูลทั้งหมด)
    // =========================
    case 'GET':

        $sql = "SELECT * FROM products";
        $result = $conn->query($sql);

        $products = [];

        while ($row = $result->fetch_assoc()) {
            $products[] = $row;
        }

        echo json_encode($products);
        break;


    // =========================
    // POST (เพิ่มข้อมูล)
    // =========================
    case 'POST':

        $data = json_decode(file_get_contents("php://input"));

        $product_name = $data->product_name;
        $price = $data->price;

        $sql = "INSERT INTO products (product_name, price) 
                VALUES ('$product_name', '$price')";

        if ($conn->query($sql)) {
            echo json_encode(["message" => "Product created"]);
        } else {
            echo json_encode(["message" => "Error"]);
        }

        break;


    // =========================
    // PUT (แก้ไขข้อมูล)
    // =========================
    case 'PUT':

        $data = json_decode(file_get_contents("php://input"));

        $id = $data->id;
        $product_name = $data->product_name;
        $price = $data->price;

        $sql = "UPDATE products 
                SET product_name='$product_name', price='$price'
                WHERE id=$id";

        if ($conn->query($sql)) {
            echo json_encode(["message" => "Product updated"]);
        } else {
            echo json_encode(["message" => "Error"]);
        }

        break;


    // =========================
    // DELETE (ลบข้อมูล)
    // =========================
    case 'DELETE':

        $data = json_decode(file_get_contents("php://input"));

        $id = $data->id;

        $sql = "DELETE FROM products WHERE id=$id";

        if ($conn->query($sql)) {
            echo json_encode(["message" => "Product deleted"]);
        } else {
            echo json_encode(["message" => "Error"]);
        }

        break;
}
?>
