<?php
	require 'database.php';
	$pdo = Database::connect();
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    if ( !empty($_POST['name']) ) {	//Αν ο χρήστης δώσει τουλάχιστον όνομα και κατηγορία
		$name = $_POST['name'];
		$quantity = $_POST['quantity'];
		$category = $_POST['category'];
		$price = $_POST['price'];
		$sql = "INSERT INTO product (name, quantity, cat_id, price, price_with_tax) values (?,?,?,?,0)";	//Τοποθέτηση στοιχείων στον πίνακα product 
		$q = $pdo->prepare($sql);
		$q->execute(array($name, $quantity, $category, $price));
		Database::disconnect();
		header("Location: index.php");
    }
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>Create Product</title>
	</head>
	<body>
		<h2>Warehouse Management CRUD Application - UNIWA Database II lab</h2>
		<form id="createProduct" action="" method="POST" >
			<table bgcolor="#f0f4ff" border="1" cellpadding="10">
				<tr align='center'>
					<td bgcolor="#cce6ff" >Name</th>
					<td><input name="name" type="text" value=""/></td>
				</tr>
				<tr align='center'>
					<td bgcolor="#9f9fdf" >Quantity</th>
					<td><input name="quantity" type="number" value=""/></td>
				</tr>
				<tr align='center'>
					<td bgcolor="#ff9999" >Category</td>
					<td><select name="category">
					<?php
						$sql = "SELECT * FROM product_category ORDER BY category_title ASC;";
						foreach ($pdo->query($sql) as $category) {
							echo '<option value="' .$category['category_id']. '">' .$category['category_title']. '</option>';
						}
					?>
					</select>
					</td>
				</tr>
				<tr align='center'>
					<td bgcolor="#ffffb3" >Price</th>
					<td>
						<input name="price" type="number" value=""/>
					</td>
				</tr>
			</table>
			<button type="submit">create</button>
		</form>
	</body>
</html>