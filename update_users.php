<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update User</title>
    <style>
        body {
            background-color: #FFF9C4;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
            font-family: 'Franklin Gothic Medium';
        }

        h1 {
            margin-bottom: 20px;
            color: #333;
        }

        form {
            background-color: #fff;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            width: 80%;
            max-width: 400px;
            text-align: center;
        }

        label, input, select {
            display: block;
            width: calc(100% - 20px);
            margin: 10px auto;
            padding: 8px;
        }

        input[type="submit"] {
            background-color: #3498db;
            color: white;
            border: none;
            padding: 8px 16px;
            cursor: pointer;
            transition: background-color 0.3s;
            width: auto;
        }

        input[type="submit"]:hover {
            background-color: #2980b9;
        }

        a {
            text-decoration: none;
            color: #3498db;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <h1>Update User</h1>
    <?php
    $conn = new mysqli("localhost", "root", "", "Lab_7");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $original_matric = $_POST['original_matric'];
        $matric = $_POST['matric'];
        $name = $_POST['name'];
        $role = $_POST['role'];

        $update_sql = "UPDATE users SET matric='$matric', name='$name', role='$role' WHERE matric='$original_matric'";
        if ($conn->query($update_sql) === TRUE) {
            echo "Record updated successfully";
            echo "<br><a href='display_users.php'>Go back to Users List</a>";
        } else {
            echo "Error updating record: " . $conn->error;
        }
    } else {
        $matric = $_GET['matric'];
        $sql = "SELECT * FROM users WHERE matric='$matric'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            ?>
            <form method="POST">
                <label for="matric">Matric:</label>
                <input type="text" id="matric" name="matric" value="<?php echo $row['matric']; ?>" required><br><br>

                <label for="name">Name:</label>
                <input type="text" id="name" name="name" value="<?php echo $row['name']; ?>" required><br><br>

                <label for="role">Role:</label>
                <select id="role" name="role" required>
                    <option value="student" <?php if($row['role'] == 'student') echo 'selected'; ?>>Student</option>
                    <option value="lecturer" <?php if($row['role'] == 'lecturer') echo 'selected'; ?>>Lecturer</option>
                </select><br><br>

                <input type="hidden" name="original_matric" value="<?php echo $row['matric']; ?>">
                <input type="submit" value="Update">
            </form>
            <?php
        } else {
            echo "No user found with that matric";
        }
    }

    $conn->close();
    ?>
</body>
</html>

