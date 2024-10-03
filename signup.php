<?php include('header.php');

if (isset($_POST['signup'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    // Check if the email already exists
    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Email already exists, show an error
        echo "<p style='color:red;'>Email is already registered. Please use a different email.</p>";
    } else {
        // Email is unique, insert the new user
        $sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $username, $email, $password);
        $stmt->execute();

        // Redirect to login page after successful registration
        header("Location: login.php");
        exit();
    }
}
?>

<form action="" method="POST">
    <h2>Sign Up</h2>
    <input type="text" name="username" placeholder="Username" required>
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit" name="signup">Sign Up</button>
</form>

<?php include('footer.php'); ?>
