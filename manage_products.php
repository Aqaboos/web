<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Products - Admin Panel</title>
    <link rel="stylesheet" href="admin_style.css"> <!-- Link to your CSS file -->
</head>
<body>
<h1>Manage Products</h1>
<!-- Product listing -->
<table>
    <thead>
        <tr>
            <th>Product ID</th>
            <th>Name</th>
            <th>Photo</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php
        include 'connection.php';
        $sql = "SELECT * FROM products";
        $result = $con->query($sql);
        while($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['id']}</td>
                    <td>{$row['name']}</td>
                    <td><img src='{$row['photo']}' alt='Product Image' style='width:100px;'></td>
                    <td>
                        <a href='edit_product.php?id={$row['id']}'>Edit</a>
                        <a href='delete_product.php?id={$row['id']}'>Delete</a>
                    </td>
                  </tr>";
        }
        ?>
    </tbody>
</table>

<!-- Add Product Form -->
<h2>Add New Product</h2>
<form action="add_product.php" method="post" enctype="multipart/form-data">
    <input type="text" name="name" placeholder="Product Name" required>
    <input type="file" name="photo" accept="image/*" required>
    <input type="submit" value="Add Product">
</form>

</body>
</html>
