<?php
// ✅ Step 6: Database connection setup for Codespace
$host = "localhost";       
$user = "root";            
$pass = "";                // Use password if you set one during mysql_secure_installation
$dbname = "carwash";       

// Create connection
$conn = new mysqli($host, $user, $pass, $dbname);

// Check connection
if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(["success" => false, "message" => "Database connection failed: " . $conn->connect_error]);
    exit();
}

// ✅ Handle form data safely
$vehicle = $_POST['vehicle'] ?? '';
$service = $_POST['service'] ?? '';
$package = $_POST['package'] ?? '';
$name = $_POST['name'] ?? '';
$email = $_POST['email'] ?? '';
$phone = $_POST['phone'] ?? '';

// Basic validation (optional)
if (empty($vehicle) || empty($service) || empty($package) || empty($name) || empty($email) || empty($phone)) {
    echo json_encode(["success" => false, "message" => "All fields are required."]);
    exit();
}

// ✅ Insert into database using prepared statements
$stmt = $conn->prepare("INSERT INTO bookings (vehicle, service, package, name, email, phone) VALUES (?, ?, ?, ?, ?, ?)");

if (!$stmt) {
    http_response_code(500);
    echo json_encode(["success" => false, "message" => "Prepare failed: " . $conn->error]);
    exit();
}

$stmt->bind_param("ssssss", $vehicle, $service, $package, $name, $email, $phone);

if ($stmt->execute()) {
    echo json_encode(["success" => true, "message" => "✅ Booking saved."]);
} else {
    http_response_code(500);
    echo json_encode(["success" => false, "message" => "Error saving booking: " . $stmt->error]);
}

$stmt->close();
$conn->close();
?>
