<?php
    require 'database.php';
    if (!empty($_POST)) {
		$name = $_POST['name'];
		if ( $name != null ) { 
			//Δημιουργία νέας κατηγορίας
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "INSERT INTO product_category (category_title) VALUES (?)";	//Τοποθέτηση των στοιχείων στον πίνακα κατηγοριών
			$q = $pdo->prepare($sql);
			$q->execute(array($name));
			Database::disconnect();
			header("Location: index.php");
		} else {
			echo "<h2>Please enter at least one value</h2>";
		}
    }
?>
