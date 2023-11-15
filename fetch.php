<?php
// Assuming you have a database connection
$conn = new mysqli("localhost", "usr", "usrpass", "sample");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch data from the database (you should customize this query based on your needs)
$sql = "SELECT * FROM users";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Convert the result to an associative array
    $data = array();
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }

    // Close the database connection
    $conn->close();

    // Send the data as JSON to the WebSocket server
    header('Content-Type: application/json');
    echo json_encode($data);
} else {
    // Handle the case where no data is found
    http_response_code(404);
    echo json_encode(array('error' => 'No data found'));
}
