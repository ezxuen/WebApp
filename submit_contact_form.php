<?php
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['name']) && isset($_POST['email']) && isset($_POST['message'])) {

        $name = htmlspecialchars($_POST['name']);
        $email = htmlspecialchars($_POST['email']);
        $message = htmlspecialchars($_POST['message']);

        $existing_query = "SELECT * FROM contacts WHERE name = ? AND message = ?";
        $existing_stmt = $conn->prepare($existing_query);
        $existing_stmt->bind_param("ss", $name, $message);
        $existing_stmt->execute();
        $existing_result = $existing_stmt->get_result();

        if ($existing_result->num_rows > 0) {
            while ($row = $existing_result->fetch_assoc()) {
                if ($row['email'] !== $email) {
                    $delete_query = "DELETE FROM contacts WHERE id = ?";
                    $delete_stmt = $conn->prepare($delete_query);
                    $delete_stmt->bind_param("i", $row['id']);
                    if ($delete_stmt->execute()) {
                        echo "Previous record deleted And new, ";
                    } else {
                        echo "Error deleting existing record: " . $conn->error;
                    }
                }
            }
        }

        $check_query = "SELECT * FROM contacts WHERE email = ?";
        $check_stmt = $conn->prepare($check_query);
        $check_stmt->bind_param("s", $email);
        $check_stmt->execute();
        $result = $check_stmt->get_result();

        if ($result->num_rows > 0) {
            $update_query = "UPDATE contacts SET name = ?, message = ? WHERE email = ?";
            $update_stmt = $conn->prepare($update_query);
            $update_stmt->bind_param("sss", $name, $message, $email);
            if ($update_stmt->execute()) {
                echo "Contact information updated successfully!";
            } else {
                echo "Error updating contact information: " . $conn->error;
            }
        } else {
            $insert_query = "INSERT INTO contacts (name, email, message) VALUES (?, ?, ?)";
            $insert_stmt = $conn->prepare($insert_query);
            $insert_stmt->bind_param("sss", $name, $email, $message);
            if ($insert_stmt->execute()) {
                echo "Contact information submitted successfully!";
            } else {
                echo "Error inserting contact information: " . $conn->error;
            }
        }

        $check_stmt->close();
        if (isset($update_stmt)) {
            $update_stmt->close();
        }
        if (isset($insert_stmt)) {
            $insert_stmt->close();
        }
    } else {
        echo "Please fill in all required fields.";
    }
} else {
    header("Location: contact.html");
    exit();
}

$conn->close();

