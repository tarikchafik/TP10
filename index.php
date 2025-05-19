<?php
$conn = new mysqli("localhost", "root", "", "stock_db");
if ($conn->connect_error) die("Échec de connexion: " . $conn->connect_error);

if (isset($_POST['add'])) {
    $name = $_POST['name'];
    $qty = $_POST['quantity'];
    $price = $_POST['price'];
    $conn->query("INSERT INTO products (name, quantity, price) VALUES ('$name', $qty, $price)");
}

if (isset($_POST['edit'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $qty = $_POST['quantity'];
    $price = $_POST['price'];
    $conn->query("UPDATE products SET name='$name', quantity=$qty, price=$price WHERE id=$id");
}

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM products WHERE id=$id");
}

$products = $conn->query("SELECT * FROM products");
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion de Stock</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <style>
   body {
    font-family: 'Roboto', sans-serif;
    background-color: #f5f7fa;
    margin: 0;
    padding: 30px;
    text-align: center;
    color: #2c3e50;
}

h2 {
    color: #2e86de;
    margin-bottom: 10px;
}

h3 {
    color: #27ae60;
    margin-bottom: 20px;
}

.container {
    display: flex;
    justify-content: center;
    align-items: flex-start;
    gap: 40px;
    flex-wrap: wrap;
    margin-top: 32px;
}

.formulaire,
.tableau {
    background-color: #ffffff;
    padding: 20px;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
}

.formulaire {
    flex: 1;
    min-width: 280px;
    max-width: 350px;
    border-top: 4px solid #27ae60;
}

.tableau {
    flex: 2;
    min-width: 600px;
    border-top: 4px solid #2e86de;
}

input[type="text"],
input[type="number"] {
    padding: 10px;
    margin: 8px 5px;
    border: 1px solid #ccc;
    border-radius: 8px;
    width: 90%;
    background-color: #fdfefe;
}

button {
    padding: 10px 18px;
    background-color: #2e86de;
    color: white;
    border: none;
    border-radius: 8px;
    font-weight: bold;
    cursor: pointer;
    margin-top: 10px;
}

button:hover {
    background-color: #1b4f72;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 10px;
}

th, td {
    padding: 14px;
    border-bottom: 1px solid #ddd;
    text-align: center;
}

th {
    background-color: #2e86de;
    color: white;
    font-weight: bold;
}

a {
    color: #c0392b;
    text-decoration: none;
    font-weight: bold;
    margin-left: 10px;
}

a:hover {
    text-decoration: underline;
    color: #922b21;
}



    </style>
</head>
<body>
<div class="container">
    <div class="formulaire">
        <h3>Ajouter un produit</h3>
        <form method="POST">
            <input type="text" name="name" placeholder="Nom" required>
            <input type="number" name="quantity" placeholder="Quantité" required>
            <input type="number" step="0.01" name="price" placeholder="Prix" required>
            <button type="submit" name="add">Ajouter</button>
        </form>
    </div>

    <div class="tableau">
        <h3>Produits en stock</h3>
        <table>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Quantité</th>
                <th>Prix</th>
                <th>Actions</th>
            </tr>
            <?php while ($row = $products->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= $row['name'] ?></td>
                    <td><?= $row['quantity'] ?></td>
                    <td><?= $row['price'] ?> dh</td>
                    <td>
                        <form method="POST" style="display:inline-block;">
                            <input type="hidden" name="id" value="<?= $row['id'] ?>">
                            <input type="text" name="name" value="<?= $row['name'] ?>" required>
                            <input type="number" name="quantity" value="<?= $row['quantity'] ?>" required>
                            <input type="number" step="0.01" name="price" value="<?= $row['price'] ?>" required>
                            <button type="submit" name="edit">Modifier</button>
                        </form>
                        <a href="?delete=<?= $row['id'] ?>" onclick="return confirm('Supprimer ce produit ?')">Supprimer</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
    </div>
</div>


</body>
</html>
