<?php
// Include your database connection or any necessary configurations
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sk_database";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Function to fetch records from the database based on the search text and pagination
function fetchRecordsFromDatabase($pageNumber, $searchText) {
    // Establish your database connection
    // Example: $conn = new mysqli($servername, $username, $password, $dbname);
    
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    // Calculate pagination limits
    $perPage = 10; // Number of records per page
    $startFrom = ($pageNumber - 1) * $perPage;

    // Construct SQL query with search condition
    $sql = "SELECT * FROM youth_barangay 
            WHERE CONCAT(first_name, ' ', middle_name, ' ', last_name) LIKE '%$searchText%'
            ORDER BY id ASC
            LIMIT $startFrom, $perPage";

    $result = $conn->query($sql);

    $records = array();

    if ($result->num_rows > 0) {
        // Fetch data from each row
        while ($row = $result->fetch_assoc()) {
            $records[] = $row;
        }
    }

    // Close the database connection
    $conn->close();

    return $records;
}

// Check if the page and search parameters are set
if (isset($_POST['page']) && isset($_POST['search'])) {
    $pageNumber = $_POST['page'];
    $searchText = $_POST['search'];

    // Fetch records from the database
    $records = fetchRecordsFromDatabase($pageNumber, $searchText);

    // Output the fetched records as JSON
    echo json_encode($records);
} else {
    // Invalid request
    echo json_encode(array('error' => 'Invalid request'));
}
?>
