<!DOCTYPE html>
<html>
<head>
    <title>Users List</title>
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
            color: black;
        }

        table {
            border-collapse: collapse;
            width: 80%;
            max-width: 800px;
            margin: 0 auto;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        th, td {
            text-align: left;
            padding: 12px;
        }

        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        a {
            text-decoration: none;
            color: #3498db;
        }

        a:hover {
            text-decoration: underline;
        }

        input[type="submit"] {
            background-color: #3498db;
            color: white;
            border: none;
            padding: 8px 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        input[type="submit"]:hover {
            background-color: #2980b9;
        }
    </style>
</head>
<body>
    <h1>Users List</h1>
    <?php
    session_start();

   
    if (!isset($_SESSION['matric'])) {
        header("Location: login.php");
        exit();
    }

    $conn = new mysqli("localhost", "root", "", "Lab_7");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['delete'])) {
            $matric = $_POST['original_matric'];

            $delete_sql = "DELETE FROM users WHERE matric='$matric'";
            if ($conn->query($delete_sql) === TRUE) {
                echo "Record deleted successfully";
            } else {
                echo "Error deleting record: " . $conn->error;
            }
        }
    }

    $sql = "SELECT matric, name, role FROM users";
    $result = $conn->query($sql);

    if ($result === false) {
        echo "Error: " . $conn->error;
    } else {
        if ($result->num_rows > 0) {
            echo "<table border='1'><tr><th>Matric</th><th>Name</th><th>Role</th><th>Action</th></tr>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                    <form method='POST'>
                        <td>" . $row["matric"] . "</td>
                        <td>" . $row["name"] . "</td>
                        <td>" . $row["role"] . "</td>
                        <td>
                            <input type='hidden' name='original_matric' value='" . $row["matric"] . "'>
                            <a href='update_users.php?matric=" . $row["matric"] . "'>Update</a>
                            <input type='submit' name='delete' value='Delete'>
                        </td>
                    </form>
                </tr>";
            }
            echo "</table>";
        } else {
            echo "0 results";
        }
    }

    $conn->close();
    ?>
</body>
</html>
