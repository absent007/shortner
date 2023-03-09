<!DOCTYPE html>
<html>
<head>
    <title>URL Shortener</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 50px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        h1 {
            text-align: center;
        }
        form {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        input[type="text"] {
            padding: 10px;
            margin: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        input[type="submit"] {
            padding: 10px 20px;
            margin: 10px;
            font-size: 16px;
            color: #fff;
            background-color: #428bca;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #3071a9;
        }
        .short-url {
            margin-top: 20px;
            font-size: 18px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>URL Shortener</h1>
        <?php
        // Connect to database
        $conn = mysqli_connect("localhost", "username", "password", "database_name");

        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        // Function to generate short URL
        function generateShortURL($long_url) {
            $short_url = substr(md5($long_url), 0, 8); // Generate a unique 8-character string
            return $short_url;
        }

        // If form is submitted
        if (isset($_POST['submit'])) {
            $long_url = $_POST['long_url'];
            $short_url = generateShortURL($long_url);

            // Insert long URL and short URL into database
            $sql = "INSERT INTO urls (long_url, short_url) VALUES ('$long_url', '$short_url')";
            if (mysqli_query($conn, $sql)) {
                echo "<div class='short-url'><a href='http://yourdomain.com/$short_url' target='_blank'>http://yourdomain.com/$short_url</a></div>";
            } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            }
        }
        ?>
        <form method="post">
            <input type="text" name="long_url" placeholder="Enter a long URL" required>
            <input type="submit" name="submit" value="Shorten">
        </form>
    </div>
</body>
</html>
