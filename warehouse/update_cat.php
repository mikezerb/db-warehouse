<?php
	require 'database.php';  
	$pdo = Database::connect();
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);   
    if ( !empty($_POST['categoryName'])) {
        $id = $_POST['categoryId'];
		$category = $_POST['categoryName'];
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "UPDATE product_category SET category_title = ? WHERE category_id = ?";
		$q = $pdo->prepare($sql);
		$q->execute(array($category, $id));
		Database::disconnect();
		header("Location: index.php");
    }
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>Update Category</title>
	</head>
	<body>
		<h2>Warehouse Management CRUD Application - UNIWA Database II lab</h2>
		<?php
			$id = $_POST['categoryId'];
			$sql = "SELECT * FROM product_category where category_id = ?";
			$q = $pdo->prepare($sql);
			$q->execute(array($id));
			$data = $q->fetch(PDO::FETCH_ASSOC);
			$category = $data['category_title'];
		?>
		<form id="updateCategory" action="" method="POST">
		<table bgcolor="#f0f4ff" border="1" cellpadding="10">
			<tr align='center'>
				<td bgcolor="#cce6ff" >Name</th>
				<td><input name="categoryName" type="text" value="<?php echo $category;?>"/></td>
			</tr>
		</table>
		<input type="hidden" id="categoryId" name="categoryId" value="<?php echo $id;?>"/>
		<button type="submit">update</button>
		</form>
	</body>
</html>