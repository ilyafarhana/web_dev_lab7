<!DOCTYPE html>
<html>
<head>
    <title>Registration Form</title>
    <style>
        body {
            background-color: #FFF9C4; 
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            font-family: 'Franklin Gothic Medium';
        }

        .container {
            text-align: center;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        form {
            display: inline-block;
        }

        label {
            display: block;
            margin: 10px 0 5px;
        }

        input[type="text"],
        input[type="password"],
        select {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        input[type="submit"] {
            padding: 10px 20px;
            background-color: #FFD700; 
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #5a0d8a; 
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Registration Form</h1>
        <?php
        
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $conn = new mysqli("localhost", "root", "", "Lab_7");

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $matric = $_POST['matric'];
            $name = $_POST['name'];
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT); 
            $role = $_POST['role'];

            $sql = "INSERT INTO users (matric, name, password, role) VALUES ('$matric', '$name', '$password', '$role')";

            if ($conn->query($sql) === TRUE) {
                echo "New record created successfully";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }

            $conn->close();
        }
        ?>

        <form action="" method="POST">
            <label for="matric">Matric:</label>
            <input type="text" id="matric" name="matric" required><br><br>
            
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required><br><br>
            
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required><br><br>
            
            <label for="role">Role:</label>
            <select id="role" name="role" required>
                <option value="">Please select</option>
                <option value="student">Student</option>
                <option value="lecturer">Lecturer</option>
            </select><br><br>
            
            <input type="submit" value="Submit"><br>
        </form>
    </div>
</body>
</html>

