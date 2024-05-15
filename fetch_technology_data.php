<?php
include 'db_connect.php';

$sql = "SELECT category, name, description ,website  FROM technologies";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table>";
    echo "<thead><tr><th>Category</th><th>Name</th><th>Description</th><th>Website</th></tr></thead>";
    echo "<tbody>";
    while($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["category"] . "</td>";
        echo "<td>" . $row["name"] . "</td>";
        echo "<td>" . $row["description"] . "</td>";
        echo '<td><a href="' . $row["website"] . '"> Link </a></td>';
        echo "</tr>";
    }
    echo "</tbody>";
    echo "</table>";
} else {
    echo "No Educationtechnologies found.";
}

$conn->close();