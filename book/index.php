<?php 
session_start();

# Database Connection File
include "db_conn.php";

# Book helper function
include "php/func-book.php";
$books = get_all_books($conn);

# author helper function
include "php/func-author.php";
$authors = get_all_author($conn);

# Category helper function
include "php/func-category.php";
$categories = get_all_categories($conn);

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Book Store</title>

    <!-- Bootstrap 5 CDN-->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js"></script>
    
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            max-width: 1200px;
            margin: auto;
        }
        .navbar {
            margin-bottom: 20px;
        }
        .card {
            width: 18rem;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: 0.3s;
        }
        .card:hover {
            transform: scale(1.05);
        }
        .category, .author-list {
            max-width: 300px;
        }
        .list-group-item.active {
            background-color: #007bff;
            border-color: #007bff;
        }
        .search-box {
            width: 100%;
            max-width: 30rem;
            margin: auto;
        }
    </style>
</head>
<body>
	<div class="container">
		<nav class="navbar navbar-expand-lg navbar-light bg-light">
		  <div class="container-fluid">
		    <a class="navbar-brand" href="index.php">Online Book Store</a>
		    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
		      <span class="navbar-toggler-icon"></span>
		    </button>
		    <div class="collapse navbar-collapse" id="navbarSupportedContent">
		      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
		        <li class="nav-item"><a class="nav-link active" href="index.php">Store</a></li>
		        <li class="nav-item"><a class="nav-link" href="#">Contact</a></li>
		        <li class="nav-item"><a class="nav-link" href="#">About</a></li>
		        <li class="nav-item">
		          <?php if (isset($_SESSION['user_id'])) {?>
		          <a class="nav-link" href="admin.php">Admin</a>
		          <?php } else { ?>
		          <a class="nav-link" href="login.php">Login</a>
		          <?php } ?>
		        </li>
		      </ul>
		    </div>
		  </div>
		</nav>
		<form action="search.php" method="get" class="search-box">
        	<div class="input-group my-4">
		      <input type="text" class="form-control" name="key" placeholder="Search Book...">
		      <button class="btn btn-primary"><img src="search.png" width="20"></button>
		    </div>
       </form>
		<div class="d-flex flex-wrap justify-content-between">
			<?php if ($books == 0) { ?>
			<div class="alert alert-warning text-center p-5 w-100">
			    <img src="img/empty.png" width="100">
			    <br>There is no book in the database
			</div>
			<?php } else { ?>
			<div class="d-flex flex-wrap">
				<?php foreach ($books as $book) { ?>
				<div class="card m-2">
					<img src="uploads/cover/<?=$book['cover']?>" class="card-img-top">
					<div class="card-body">
						<h5 class="card-title"><?=$book['title']?></h5>
						<p class="card-text">
							<i><b>By: 
							<?php foreach($authors as $author){ 
							if ($author['id'] == $book['author_id']) echo $author['name'];} ?>
							<br>Category: 
							<?php foreach($categories as $category){ 
							if ($category['id'] == $book['category_id']) echo $category['name'];} ?>
							</b></i>
						</p>
						<a href="uploads/files/<?=$book['file']?>" class="btn btn-success">Open</a>
						<a href="uploads/files/<?=$book['file']?>" class="btn btn-primary" download="<?=$book['title']?>">Download</a>
					</div>
				</div>
				<?php } ?>
			</div>
			<?php } ?>
			<div class="category">
				<div class="list-group">
					<?php if ($categories != 0) { ?>
					<a class="list-group-item active">Category</a>
					<?php foreach ($categories as $category) { ?>
					<a href="category.php?id=<?=$category['id']?>" class="list-group-item"> <?=$category['name']?></a>
					<?php } } ?>
				</div>
				<div class="list-group mt-4 author-list">
					<?php if ($authors != 0) { ?>
					<a class="list-group-item active">Author</a>
					<?php foreach ($authors as $author) { ?>
					<a href="author.php?id=<?=$author['id']?>" class="list-group-item"> <?=$author['name']?></a>
					<?php } } ?>
				</div>
			</div>
		</div>
	</div>
</body>
</html>
