<?php
// Include the database connection file
include 'includes/conn.php';

// Query to retrieve the audit log
$query = "SELECT * FROM audit_log";
$result = mysqli_query($conn, $query);

// Check if the query was successful
if (!$result) {
    die("Error retrieving audit log: ". mysqli_error($conn));
}

// Display the audit log
echo "<h1>Audit Log</h1>";
echo "<table border='1'>";
echo "<tr><th>Timestamp</th><th>Event</th><th>Description</th></tr>";

while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr>";
    echo "<td style='width: 200px;'>". $row['timestamp']. "</td>";
    echo "<td style='width: 200px;'>". $row['action']. "</td>";
    echo "<td style='width: 400px;'>". $row['description']. "</td>";
    echo "</tr>";
}

echo "</table>";

// Close the database connection
mysqli_close($conn);
?>