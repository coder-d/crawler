<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Login</title>
    <!-- Add your CSS links here from assets directory -->
</head>
<body>
    <h1>Admin Login</h1>
    <?php if (isset($_GET['error']) && $_GET['error'] == 1): ?>
        <p style="color:red;">Invalid Credentials</p>
    <?php endif; ?>
    <form action="<?php echo $baseUrl; ?>views/do-login" method="POST">
        <div>
            <label for="username">Username:</label>
            <input type="text" id="username" name="username">
        </div>
        <div>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password">
        </div>
        <div>
            <button type="submit">Login</button>
        </div>
    </form>
</body>
</html>