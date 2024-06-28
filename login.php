<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
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
            background-color: white;
            padding: 60px;
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
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        input[type="submit"] {
            padding: 10px 20px;
            background-color: #FFEB3B;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #5a0d8a; 
        }

        .success {
            color: green;
        }

        .error {
            color: red;
        }

        a {
            color: #FFD700;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Login</h1>
        <?php
        session_start();
        $message = '';

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $conn = new mysqli("localhost", "root", "", "Lab_7");

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $matric = $_POST['matric'];
            $password = $_POST['password'];

            $sql = "SELECT password FROM users WHERE matric='$matric'";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                if (password_verify($password, $row['password'])) {
                    $_SESSION['matric'] = $matric;
                    $message = "Login successful!";
                    echo "<p class='success'>$message</p>";
                    header("Refresh: 2; URL=display_users.php");
                    exit();
                } else {
                    $message = "Invalid password";
                    echo "<p class='error'>$message</p>";
                }
            } else {
                $message = "No user found with that matric";
                echo "<p class='error'>$message</p>";
            }

            $conn->close();
        }
        ?>

        <form action="" method="POST">
            <label for="matric">Matric:</label>
            <input type="text" id="matric" name="matric" required><br><br>
            
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required><br><br>
            
            <input type="submit" value="Login">
        </form>
        <p><a href="registration.php">Register</a> if you have not.</p>
    </div>
</body>
</html>
