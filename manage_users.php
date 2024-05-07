<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Users - Admin Panel</title>
    <link rel="stylesheet" href="admin_style.css"> <!-- Link to your CSS file -->
</head>
<body>
<h1>Manage Users</h1>
<!-- User listing -->
<table>
    <thead>
        <tr>
            <th>User ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php
        include 'connection.php';
        $sql = "SELECT * FROM users";
        $result = $con->query($sql);
        while($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['id']}</td>
                    <td>{$row['name']}</td>
                    <td>{$row['email']}</td>
                    <td>
                        <a href='edit_user.php?id={$row['id']}'>Edit</a>
                        <a href='delete_user.php?id={$row['id']}'>Delete</a>
                    </td>
                  </tr>";
        }
        ?>
    </tbody>
</table>

<!-- Add User Form -->
<h2>Add New User</h2>
<form action="add_user.php" method="post">
    <input type="text" name="name" placeholder="Name" required>
    <input type="email" name="email" placeholder="Email" required>
    <input type="submit" value="Add User">
</form>

</body>
</html>
