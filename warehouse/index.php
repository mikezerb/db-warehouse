<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Warehouse Management</title>
		<meta charset="utf-8">
		<script type="text/javascript">
			function deleteProduct(id) {	// Function διαγραφής προϊόντος
				document.getElementById("productId").value = id;
				document.forms["viewProducts"].action = "delete_prod.php";	//Καλούμε το php για την διαγραφή του προϊόντος
				document.forms["viewProducts"].submit(); 
			}
			function updateProduct(id) {	//Function αλλαγής στοιχείων προϊόντος 
				document.getElementById("productId").value = id;
				document.forms["viewProducts"].action = "update_prod.php"; 	//Καλούμε το php για την αλλαγή προϊόντος
				document.forms["viewProducts"].submit(); 
			}
			function viewProduct(id) {	//Function εμφάνισης προϊόντος
				document.getElementById("productId").value = id;
				document.forms["viewProducts"].action = "view.php";	//Καλούμε το php για να εμφανίζονται τα στοιχεία του προϊόντος
				document.forms["viewProducts"].submit(); 
			}
			function deleteCategory(id) {	//Function διαγραφής κατηγορίας προϊόντων
				document.getElementById("categoryId").value = id;
				document.forms["viewCategory"].action = "delete_cat.php";	//Καλούμε το php για την διαγραφή της κατηγορίας
				document.forms["viewCategory"].submit(); 
			}
			function updateCategory(id) {	//Function αλλαγής στοιχείων κατηγορίας
				document.getElementById("categoryId").value = id;
				document.forms["viewCategory"].action = "update_cat.php";	//Καλούμε το php για την αλλαγή των στοιχείων 
				document.forms["viewCategory"].submit(); 
			}
		</script>
	</head>
	<body>
		<?php include 'database.php'; ?>
		<h2>Warehouse Management CRUD Application - UNIWA Database II lab</h2>
		<h3><u>Products</u></h3>
		<table bgcolor="#f0f4ff" border="1" cellpadding="10">
			<tr align='center'>
				<th bgcolor="#cce6ff">Name</th>
				<th bgcolor="#9f9fdf">Quantity</th>
				<th bgcolor="#ff9999">Action</th>
			</tr>
			<form id="viewProducts" method="POST">
				<input type="hidden" id="productId" name="productId" value=""/>
				<?php
				$pdo = Database::connect();
				$sql = 'SELECT * FROM product ORDER BY name ASC';
				foreach ($pdo->query($sql) as $product) {
							echo "<tr align='center'>";
							echo '<td>'. $product['name'] . '</td>';
							echo '<td>'. $product['quantity'] . '</td>';
							echo '<td><button type="button" onclick="viewProduct('.$product['id'].')">view</button>';
							echo '<button type="button" onclick="updateProduct('.$product['id'].')">update</button>';
							echo '<button type="button" onclick="deleteProduct('.$product['id'].')">delete</button></td>';
							echo '</tr>';
				}
				?>
			</form>
		</table>
		<form id="createProdButton" action="create_prod.php" method="POST">
			<button type="submit">- Create Product -</button>
		</form>
		<br>
		<!-- Πίνακας κατηγοριών -->
		<h3><u>Categories</u></h3>
		<table bgcolor="#f0f4ff" border="1" cellpadding="10">
			<tr align='center'>
				<th bgcolor="#cce6ff"> Name </th>
				<th bgcolor="#ff9999">Action</th>
			</tr>
			<form id="viewCategory" method="POST">
				<input type="hidden" id="categoryId" name="categoryId" value=""/>
				<?php
				$sql = 'SELECT * FROM product_category ORDER BY category_id ASC';
				foreach ($pdo->query($sql) as $category) {
							echo "<tr align='center'>";
							echo '<td>'. $category['category_title'] . '</td>';
							echo '<td><button type="button" onclick="updateCategory('.$category['category_id'].')">update</button>';
							echo '<button type="button" onclick="deleteCategory('.$category['category_id'].')">delete</button></td>';
							echo '</tr>';
				}
				Database::disconnect();
				?>
			</form>
		</table>
		<form id="createCatButton" action="create_cat.html" method="POST">
			<button type="submit">- Create Category -</button>
		</form>
	</body>
</html>
