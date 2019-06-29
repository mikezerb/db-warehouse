<?php
    require 'database.php';
	$pdo = Database::connect();
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    if ( !empty($_POST['name']) && !empty($_POST['productId']) && !empty($_POST['category'])) {	//Πρέπει να υπάρχει τουλάχιστον όνομα, id προϊόντος και id κατηγορίας για να συνεχίσει
        $id = $_POST['productId'];
		$name = $_POST['name'];
		$quantity = $_POST['quantity'];
		$category = $_POST['category'];
		$price = $_POST['price'];
		$sql = "UPDATE product SET name = ?, quantity = ?, cat_id = ?, price = ? WHERE id = ?";	//Αλλαγή του πίνακα product στην βάση 
		$q = $pdo->prepare($sql);
		$q->execute(array($name,$quantity,$category,$price,$id));
		Database::disconnect();
		header("Location: index.php");
    }
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>Update Product</title>
	</head>
	<body>
		<h2>Warehouse Management CRUD Application - UNIWA Database II lab</h2>
		<?php
			$id = $_POST['productId'];
			$sql = "SELECT * FROM product where id = ?";
			$q = $pdo->prepare($sql);
			$q->execute(array($id));
			$data = $q->fetch(PDO::FETCH_ASSOC);
			$name = $data['name'];
			$quantity = $data['quantity'];
			$categoryId = $data['cat_id'];
			$price = $data['price'];
		?>
		<form id="updateProduct" action="" method="POST">
			<input type="hidden" id="productId" name="productId" value="<?php echo $id;?>"/>
			<table bgcolor="#f0f4ff" border="1" cellpadding="10">
				<tr align='center'>
					<td bgcolor="#cce6ff">Name</th>
					<td>
						<input name="name" type="text" value="<?php echo $name;?>"/
					></td>
				</tr>
				<tr align='center'>
					<td bgcolor="#9f9fdf" >Quantity</th>
					<td>
						<input name="quantity" type="number" value="<?php echo $quantity;?>"/>
					</td>
				</tr>
				<tr align='center'>
					<td bgcolor="#adc2eb" >Category</td>
					<td><select name="category">
						<?php
							$sql = "SELECT category_title FROM product_category WHERE category_id = ?";	//Το όνομα της υπάρχουσας κατηγορίας του προϊόντος
							$q = $pdo->prepare($sql);
							$q->execute(array($categoryId));
							$categoryName = $q->fetch(PDO::FETCH_ASSOC);
							echo '<option value="' .$categoryId. '">' .$categoryName['category_title']. '</option>';
							$sql = "SELECT * FROM product_category ORDER BY category_title ASC;";	//Για την εμφάνιση όλων των κατηγοριών 
							foreach ($pdo->query($sql) as $category) {
								if ($category['category_id'] != $categoryId){
									echo '<option value="' .$category['category_id']. '">' .$category['category_title']. '</option>';
								}
							}
						?>
					</select></td>
				</tr>
				<tr align='center'>
					<td bgcolor="#ffffb3" >Price</th>
					<td>
						<input name="price" type="number" step="0.01" value="<?php echo $price;?>"/>
					</td>
				</tr>
			</table>
			<button type="submit">update</button>
		</form>
	</body>
</html>
