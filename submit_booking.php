<?php
// ✅ Step 6: Database connection setup
$host = "localhost";       // XAMPP server host
$user = "root";            // XAMPP default user
$pass = "";                // XAMPP default has no password
$dbname = "carwash";       // Your database name

// Create connection
$conn = new mysqli($host, $user, $pass, $dbname);

// Check connection
if ($conn->connect_error) {
  die(json_encode(["success" => false, "message" => "Connection failed: " . $conn->connect_error]));
}

// ✅ Handle form data
$vehicle = $_POST['vehicle'] ?? '';
$service = $_POST['service'] ?? '';
$package = $_POST['package'] ?? '';
$name = $_POST['name'] ?? '';
$email = $_POST['email'] ?? '';
$phone = $_POST['phone'] ?? '';

// ✅ Insert into database
$stmt = $conn->prepare("INSERT INTO bookings (vehicle, service, package, name, email, phone) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssss", $vehicle, $service, $package, $name, $email, $phone);

if ($stmt->execute()) {
  echo json_encode(["success" => true, "message" => "Booking saved."]);
} else {
  echo json_encode(["success" => false, "message" => "Error: " . $stmt->error]);
}

// ✅ Close connection
$stmt->close();
$conn->close();
?>
