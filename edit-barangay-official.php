<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sk_database";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if ID parameter is set in the URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch record details from the database based on the ID
    $sql = "SELECT * FROM barangay_official WHERE id = $id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Display an editable form with pre-filled data
        $row = $result->fetch_assoc();
        ?>
<!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editModal">
  Edit Barangay Official
</button>

<!-- Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editModalLabel">Edit Barangay Official</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="update-barangay-officials.php" method="post">
          <input type="hidden" name="id" value="<?php echo $id; ?>">
          <div class="mb-3">
            <label for="first_name" class="form-label">First Name:</label>
            <input type="text" name="first_name" value="<?php echo $row['first_name']; ?>" class="form-control">
          </div>
          <div class="mb-3">
            <label for="middle_name" class="form-label">Middle Name:</label>
            <input type="text" name="middle_name" value="<?php echo $row['middle_name']; ?>" class="form-control">
          </div>
          <div class="mb-3">
            <label for="last_name" class="form-label">Last Name:</label>
            <input type="text" name="last_name" value="<?php echo $row['last_name']; ?>" class="form-control">
          </div>
          <div class="mb-3">
            <label for="gender" class="form-label">Gender:</label>
            <input type="text" name="gender" value="<?php echo $row['gender']; ?>" class="form-control">
          </div>
          <div class="mb-3">
            <label for="contact_no" class="form-label">Contact No.:</label>
            <input type="text" name="contact_no" value="<?php echo $row['contact_no']; ?>" class="form-control">
          </div>
          <div class="mb-3">
            <label for="committee" class="form-label">Committee:</label>
            <input type="text" name="committee" value="<?php echo $row['committee']; ?>" class="form-control">
          </div>
          <div class="mb-3">
            <label for="barangay_position" class="form-label">Barangay Position:</label>
            <input type="text" name="barangay_position" value="<?php echo $row['barangay_position']; ?>" class="form-control">
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Update</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>


        <?php
    } else {
        echo "Record not found.";
    }
} else {
    echo "ID parameter not set.";
}

// Close database connection
$conn->close();
?>