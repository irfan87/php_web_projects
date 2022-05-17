<?php
$pdo = new PDO('mysql:host=localhost;port=3306;dbname=products_crud', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$errors = [];

$title = '';
$price = '';
$description = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	// save the data without the image
	$title = $_POST['title'];
	$description = $_POST['description'];
	$price = $_POST['price'];
	$date = date('Y-m-d H:i:s');


	// validate forms below
	if (!$title) {
		// raised the error
		$errors[] = 'Product title is required';
	}

	if (!$price) {
		$errors[] = 'Product price is required';
	}

	// check if the images directory exist or not.
	// if exists, the temporary image will store in that directory with the random index string
	if (!is_dir('images')) {
		mkdir('images');
	}

	if (empty($errors)) {
		// check if the image have been uploaded
		$image = $_FILES['image'] ?? null;
		$imagePath = '';

		if ($image && $image['tmp_name']) {
			$imagePath = 'images/' . randomString(8) . '/' . $image['name'];
			mkdir(dirname($imagePath));

			move_uploaded_file($image['tmp_name'], $imagePath);
		}

		// exit;

		// insert the data into the database and save it
		$statement = $pdo->prepare("INSERT INTO products (image, title, description, price, created_at) VALUES (:image, :title, :description, :price, :date)");

		$statement->bindValue(':image', $imagePath);
		$statement->bindValue(':title', $title);
		$statement->bindValue(':description', $description);
		$statement->bindValue(':price', $price);
		$statement->bindValue(':date', $date);

		$statement->execute();

		// redirect to the root page
		header('Location: index.php');
	}
}

function randomString($n)
{
	$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$str = '';

	for ($i = 0; $i < $n; $i++) {
		$index = rand(0, strlen($characters) - 1);
		$str .= $characters[$index];
	}

	return $str;
}

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
	<?php if (!empty($errors)) : ?>
	<div class="alert alert-danger">
		<?php foreach ($errors as $error) : ?>
		<div>
			<?php echo $error; ?>
		</div>
		<?php endforeach ?>
	</div>
	<?php endif ?>
	<form action="" method="post" enctype="multipart/form-data">
		<div class="form-group">
			<label>Product Image</label>
			<br>
			<input type="file" name="image">
		</div>
		<div class="form-group">
			<label>Product Title</label>
			<input type="text" class="form-control" name="title" value="<?php echo $title; ?>">
		</div>
		<div class="form-group">
			<label>Product Description</label>
			<textarea class="form-control" name="description"><?php echo $description; ?></textarea>
		</div>
		<div class="form-group">
			<label>Product Price</label>
			<input type="number" step=".01" class="form-control" name="price" value="<?php echo $price; ?>">
		</div>
		<button type="submit" class="btn btn-primary">Submit</button>
	</form>
</body>

</html>