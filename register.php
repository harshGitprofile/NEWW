<?php

$host = "localhost";
$port = "3306";
$username = "root";
$password = "Harshraj6030@";
$database = "student_db";

// Connect to MySQL
$conn = mysqli_connect(
    $host,
    $username,
    $password,
    $database,
    $port
);

// Check connection
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Only allow POST requests
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    die("Invalid request.");
}

// Get form data
$full_name = trim($_POST["full_name"] ?? "");
$email = trim($_POST["email"] ?? "");
$phone = trim($_POST["phone"] ?? "");
$dob = $_POST["dob"] ?? "";
$gender = $_POST["gender"] ?? "";
$course = $_POST["course"] ?? "";
$semester = $_POST["semester"] ?? "";
$roll_number = trim($_POST["roll_number"] ?? "");
$address = trim($_POST["address"] ?? "");

// Validate empty fields
if (
    empty($full_name) ||
    empty($email) ||
    empty($phone) ||
    empty($dob) ||
    empty($gender) ||
    empty($course) ||
    empty($semester) ||
    empty($roll_number) ||
    empty($address)
) {
    die("Please fill in all required fields.");
}

// Validate email
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    die("Please enter a valid email address.");
}

// Validate phone
if (!preg_match("/^[0-9]{10}$/", $phone)) {
    die("Please enter a valid 10-digit phone number.");
}

// SQL query
$sql = "INSERT INTO students
        (full_name, email, phone, dob, gender, course, semester, roll_number, address)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

// Prepare query
$stmt = mysqli_prepare($conn, $sql);

if (!$stmt) {
    die("SQL preparation failed: " . mysqli_error($conn));
}

// Bind values
mysqli_stmt_bind_param(
    $stmt,
    "ssssssiss",
    $full_name,
    $email,
    $phone,
    $dob,
    $gender,
    $course,
    $semester,
    $roll_number,
    $address
);

// Execute
if (mysqli_stmt_execute($stmt)) {

    echo "<h2>Registration Successful!</h2>";

    echo "<p>Student <strong>" .
         htmlspecialchars($full_name) .
         "</strong> has been registered successfully.</p>";

    echo "<p><a href='index.html'>Register another student</a></p>";

} else {

    echo "Registration failed: " .
         htmlspecialchars(mysqli_stmt_error($stmt));
}

// Close
mysqli_stmt_close($stmt);
mysqli_close($conn);

?>