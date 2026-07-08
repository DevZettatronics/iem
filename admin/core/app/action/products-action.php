<?php
$con = Database::getCon();
if (isset($_GET["opt"]) && $_GET["opt"] == "add") {
	if (count($_POST) > 0) {
		require_once("libraries/inventory.php");
	
		$category_id = $_POST["category_id"];
		$product_code = $_POST["product_code"];
		$product_name = $_POST["product_name"];
		$note = $_POST["note"];
		$selling_price = $_POST["selling_price"];
		$stock = 10000000; //10 millones en stock
		$status = $_POST["status"];
		$presentation = $_POST["ClaveUnidad"];
		$image_path = 'img/productos/product.png';
		$created_at = date("Y-m-d H:i:s");
		$clave = $_POST['clave'];
	
		mysqli_begin_transaction($con);
	
		try {
			// Inserta el producto
			$stmt = mysqli_prepare($con, "INSERT INTO products (product_code, product_name, note, status, category_id, selling_price, created_at, presentation, image_path, clave_sat) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
			mysqli_stmt_bind_param($stmt, "ssssdisdss", $product_code, $product_name, $note, $status, $category_id, $selling_price, $created_at, $presentation, $image_path, $clave);
			mysqli_stmt_execute($stmt);
	
			$product_id = mysqli_insert_id($con);
	
			// Actualiza inventario
			if ($stock > 0) {
				$sql = mysqli_query($con, "SELECT COUNT(*) FROM inventory WHERE product_id='$product_id'"); 
				$count = mysqli_fetch_row($sql)[0];  // Obtener solo el conteo
				if ($count == 0) {
					$insert = mysqli_query($con, "INSERT INTO inventory (product_id, product_quantity) VALUES ('$product_id','$stock')");
				} else {
					$update = mysqli_query($con, "UPDATE inventory SET product_quantity='$stock' WHERE product_id='$product_id'");
				}
			}
	
			// Si todo va bien, hacer commit
			mysqli_commit($con);
	
			Core::redir("./?view=productos&opt=all");
		} catch (Exception $e) {
			mysqli_rollback($con);
			error_log("Error en la consulta: " . $e->getMessage());
		}
	}
}

if ($_GET["opt"] && $_GET["opt"] == "update") {
	if (count($_POST) > 0) {
		$product_id = $_POST["product_id"];
		$stock = 10000000; //10 millones en stock
		$a = ProductsData::getCambio($_POST["product_id"]);
		$a->category_id = $_POST["category_id"];
		$a->product_code = $_POST["product_code"];
		$a->product_name = $_POST["product_name"];
		$a->note = $_POST["note"];
		$a->selling_price = $_POST["selling_price"];
		// $a->clave_sat = $_POST['clave'];
		 // Obtener el valor de clave_anterior
		$clave_anterior = (isset($a->clave_sat) && $a->clave_sat != "") ? $a->clave_sat : 'No asignado';

		 // Verificar si clave_anterior tiene valor y $_POST['clave'] está vacío para mantener el valor existente
		if ($clave_anterior != 'No asignado' && empty($_POST['clave'])) {
			$a->clave_sat = $clave_anterior;
		} else {
			 // Actualizar con el valor de $_POST['clave']
		$a->clave_sat = $_POST['clave'];
		}

		mysqli_begin_transaction($con);

		try {
			$a->update(); // esta debe lanzar excepción si falla

			$stmt = mysqli_prepare($con,"SELECT * FROM inventory WHERE product_id = ?");
			if (!$stmt) throw new Exception("Error al preparar SELECT inventory");

			mysqli_stmt_bind_param($stmt,"i",$product_id);
			if (!mysqli_stmt_execute($stmt)) throw new Exception("Error al ejecutar SELECT inventory");

			$result = mysqli_stmt_get_result($stmt);
			if (mysqli_num_rows($result) > 0) {
				$update = mysqli_prepare($con, "UPDATE inventory SET product_quantity = ? WHERE product_id = ?");
				if (!$update) throw new Exception("Error al preparar UPDATE inventory");

				mysqli_stmt_bind_param($update, "ii", $stock, $product_id);
				if (!mysqli_stmt_execute($update)) throw new Exception("Error al ejecutar UPDATE inventory");
			} else {
				$insert = mysqli_prepare($con, "INSERT INTO inventory (product_id, product_quantity) VALUES (?, ?)");
				if (!$insert) throw new Exception("Error al preparar INSERT inventory");

				mysqli_stmt_bind_param($insert, "ii", $product_id, $stock);
				if (!mysqli_stmt_execute($insert)) throw new Exception("Error al ejecutar INSERT inventory");
			}

			mysqli_commit($con);
			Core::alert("Asignatura Actualizada Exitosamente!");
			Core::redir("./?view=productos&opt=all");

		} catch (Exception $e) {
			mysqli_rollback($con);
			error_log("Error en la transacción: " . $e->getMessage());
		}
	}
}
if (isset($_GET["opt"]) && $_GET["opt"] == "del") { /*ELIMINACION  */

	$user = ProductsData::getCambio($_GET["product_id"]);
	$user->del();

	Core::redir("./?view=productos&opt=all");
}

if (isset($_POST['opt']) && $_POST['opt'] == 'updateStatus') 
{
	$product_id = $_POST['product_id'];
    $status = $_POST['status'];

    // Construye la consulta SQL
    $sql = "UPDATE products SET status = '$status' WHERE product_id = '$product_id'";

    // Ejecuta la consulta
    $query = mysqli_query($con, $sql);

    // Verifica si la consulta fue exitosa
    if ($query) {
        echo "Actualización exitosa";
		
    } else {
        echo "Error al actualizar";
    }
}