<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
</head>
	<body>
	<h3>Warehouse Management CRUD Application - UNIWA Database II lab</h3>
	<?php
		include 'database.php';
		$id = $_POST['productId'];
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "SELECT * FROM product INNER JOIN product_category ON product.cat_id = product_category.category_id where id = ?";	//Κάνουμε inner join για να εμφανίσουμε όλα τα στοιχεία του προϊόντος με το συγκεκριμένο id. 
		$q = $pdo->prepare($sql);
		$q->execute(array($id));
		$data = $q->fetch(PDO::FETCH_ASSOC);
		$name = $data['name'];
		$quantity = $data['quantity'];
		$cat_title = $data['category_title'];	
		$price = $data['price'];
		$price_tax = $data['price_with_tax'];
		Database::disconnect();
	  ?>
		<table bgcolor="#f0f4ff" border="1" cellpadding="10">
			<tr align='center'>
				<td bgcolor="#cce6ff">Name</th>
				<td><?php echo $name;?></td>
			</tr>
			<tr align='center'>
				<td bgcolor="#9f9fdf" >Quantity</th>
				<td><?php echo $quantity;?></td>
			</tr>
			<tr align='center'>
				<td bgcolor="#ff9999" >Category</th>
				<td><?php echo $cat_title;?></td>
			</tr>
			<tr align='center'>
				<td bgcolor="#ffffb3" >Price</th>
				<td><?php echo $price;?></td>
			</tr>
			<tr align='center'>
				<td bgcolor="#ffe6b3" >Price with tax</th>
				<td><?php echo $price_tax;?></td>
			</tr>
		</table>
		<form id="returnFrom" action="index.php" method="GET">
		<button type="submit">back</button>
		</form>
	</body>
</html>