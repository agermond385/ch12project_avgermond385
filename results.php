<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Searching a Database with PHP and MySQL</title>
    <link rel="stylesheet" href="styles/main.css">
</head>
<body>
    <h1>Searching a Database with PHP and MySQL</h1>
    <p>Annabelle Germond</p>
    <p>April 25, 2026</p>

    <?php
    // This block checks if the form was submitted using POST
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // This block stores the email, removes whitespace,
        // and sanitizes it.
        $email = trim($_POST["email"]);
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);
        // This block connects to the taus_data DB
        $connection = mysqli_connect("localhost", "soft", "mysql", "taus_data");

        //This block displays an error message if conn fails
        if (!$connection) {
            echo "<div class='message'>Database connection failed.</div>";
        } else {
        // This block creates and runs an SQL query
            $emailEscaped = mysqli_real_escape_string($connection, $email);
            $sql = "SELECT firstName, lastName, email FROM tbl_student WHERE email = '$emailEscaped'";
            $result = mysqli_query($connection, $sql);

            // This block checks if a matching email was found
            if ($result && mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                echo "<div class='message'>Student found: " . htmlspecialchars($row["firstName"]) . " " . htmlspecialchars($row["lastName"]) . " (" . htmlspecialchars($row["email"]) . ")</div>";
            } else {
                echo "<div class='message'>Email not found.</div>";
            }

            mysqli_close($connection);
        }
    } else {
        // This block displays a message if the page is opened without submitting the form
        echo "<div class='message'>Please submit the form first.</div>";
    }
    ?>

    <p><a href="index.php">Back to Search</a></p>
</body>
</html>