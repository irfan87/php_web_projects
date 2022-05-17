<?php
$pdo = new PDO('mysql:host=localhost;port=3306;dbname=products_crud', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

?>
<!doctype html>
<html lang="en">

<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
		integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
	<link rel="stylesheet" href="styles.css">
	<title>Products CRUD</title>
</head>

<body>
	<h1>Create New Product</h1>

	<form>
		<div class="form-group">
			<label>Product Image</label>
			<br>
			<input type="file">
		</div>
		<div class="form-group">
			<label>Product Title</label>
			<input type="text" class="form-control">
		</div>
		<div class="form-group">
			<label>Product Description</label>
			<textarea class="form-control"></textarea>
		</div>
		<div class="form-group">
			<label>Product Price</label>
			<input type="number" step=".01" class="form-control">
		</div>
		<button type="submit" class="btn btn-primary">Submit</button>
	</form>
</body>

</html>