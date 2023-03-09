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
        echo "Short URL: http://yourdomain.com/$short_url";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}

// If short URL is requested
if (isset($_GET['url'])) {
    $short_url = $_GET['url'];

    // Retrieve long URL from database
    $sql = "SELECT long_url FROM urls WHERE short_url = '$short_url'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $long_url = $row['long_url'];

    // Redirect to long URL
    header("Location: $long_url");
    exit();
}

// Close database connection
mysqli_close($conn);
?>

<!-- HTML form -->
<form method="POST" action="">
    <input type="text" name="long_url" placeholder="Enter long URL">
    <button type="submit" name="submit">Shorten</button>
</form>
