<?php 
session_start();

# Database Connection File
include "db_conn.php";

# Book helper function
include "php/func-book.php";
$books = get_all_books($conn);

# Author helper function
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

    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        /* General Styling */
        body {
            background-color: #f8f9fa;
            font-family: 'Poppins', sans-serif;
            color: #333;
        }
        
        /* Navbar Styling */
        .navbar {
            background-color:rgb(10, 203, 183);
            height: 80px;
            padding: 15px 30px;
            box-shadow: 0 2px 10px rgba(0,150,136);
        }

        .navbar-brand {
            font-size: 40px;
            font-weight: bold;
            color: #ecf0f1 !important;
        }

        .navbar-nav .nav-link {
            color: #ecf0f1 !important;
            font-size: 16px;
            padding: 10px 20px;
            font-weight: 500;
        }

        .navbar-nav .nav-link:hover {
            color: #3498db !important;
        }

        /* Sidebar (Category Menu) */
        .sidebar {
            width: 250px;
            background-color:hsl(170, 100.00%, 28.60%);
            color: #ecf0f1;
            position: fixed;
            height: 100%;
            padding-top: 20px;
            left: 0;
            top: 80px;
            box-shadow: 2px 0 10px rgba(0,0,0,0.1);
            z-index: 100;
        }

        .sidebar h3 {
            font-size: 18px;
            font-weight: 600;
            padding: 15px 20px;
            border-bottom: 1px solid #2c3e50;
            margin-bottom: 15px;
            color: #ecf0f1;
        }

        .sidebar a {
            padding: 12px 20px;
            display: block;
            color: #bdc3c7;
            text-decoration: none;
            transition: 0.3s;
            font-size: 15px;
        }

        .sidebar a:hover {
            background-color: #2c3e50;
            color: #3498db;
        }

        /* Main Content Adjustments */
        .content {
            margin-left: 270px;
            padding: 30px;
            margin-top: 80px;
        }

        /* Search Box */
        .search-box {
            width: 100%;
            margin-bottom: 40px;
        }

        .search-box .input-group {
            max-width: 600px;
            margin: 0 auto;
        }

        .search-box input {
            border-radius: 30px 0 0 30px;
            padding: 12px 20px;
            border: 1px solid #ddd;
        }

        .search-box button {
            border-radius: 0 30px 30px 0;
            padding: 0 20px;
            background-color: #3498db;
            border: none;
        }

        /* Hero Image Banner */
        .hero-banner {
            width: 100%;
            height: 400px;
            background-image: url('https://images.unsplash.com/photo-1507842217343-583bb7270b66?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80');
            background-size: cover;
            background-position: center;
            border-radius: 8px;
            margin-bottom: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }

        .hero-banner::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.4);
            border-radius: 8px;
        }

        .hero-content {
            position: relative;
            z-index: 1;
            color: white;
            text-align: center;
            padding: 20px;
            max-width: 800px;
        }

        .hero-content h2 {
            font-size: 42px;
            font-weight: 700;
            margin-bottom: 20px;
            text-shadow: 1px 1px 3px rgba(0,0,0,0.5);
        }

        .hero-content p {
            font-size: 20px;
            margin-bottom: 30px;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.5);
        }

        .btn-hero {
            background-color: #3498db;
            color: white;
            padding: 12px 30px;
            font-size: 18px;
            font-weight: 600;
            border-radius: 30px;
            border: none;
            transition: all 0.3s;
        }

        .btn-hero:hover {
            background-color: #2980b9;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }

        /* Featured Books Section */
        .featured-books {
            margin-top: 60px;
            text-align: center;
        }

        .section-heading {
            font-size: 36px;
            font-weight: 700;
            margin-bottom: 40px;
            color: #2c3e50;
            position: relative;
            display: inline-block;
        }

        .section-heading:after {
            content: '';
            position: absolute;
            left: 50%;
            bottom: -10px;
            width: 80px;
            height: 4px;
            background-color: #3498db;
            transform: translateX(-50%);
        }

        /* Book Cards */
        .card {
            width: 16rem;
            box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.1);
            transition: all 0.3s;
            border: none;
            border-radius: 8px;
            overflow: hidden;
            margin-bottom: 30px;
        }

        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.15);
        }

        .card-img-top {
            height: 220px;
            object-fit: cover;
        }

        .card-body {
            padding: 20px;
        }

        .card-title {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 10px;
            color: #2c3e50;
        }

        .card-text {
            font-size: 14px;
            color: #7f8c8d;
            margin-bottom: 15px;
        }

        .btn-primary {
            background-color: #3498db;
            border: none;
            padding: 8px 15px;
            font-size: 14px;
            border-radius: 4px;
        }

        .btn-primary:hover {
            background-color: #2980b9;
        }

        .btn-success {
            background-color: #2ecc71;
            border: none;
            padding: 8px 15px;
            font-size: 14px;
            border-radius: 4px;
        }

        .btn-success:hover {
            background-color: #27ae60;
        }

        /* Responsive Adjustments */
        @media (max-width: 992px) {
            .sidebar {
                display: none;
            }
            .content {
                margin-left: 0;
            }
            
            .hero-banner {
                height: 300px;
            }
            
            .hero-content h2 {
                font-size: 32px;
            }
            
            .hero-content p {
                font-size: 16px;
            }
            
            .section-heading {
                font-size: 28px;
            }
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">BookVerse</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto">
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
    
    <div class="sidebar">
        <h3>ALL CATEGORIES</h3>
        <?php if ($categories != 0) { ?>
            <?php foreach ($categories as $category) { ?>
                <a href="category.php?id=<?=$category['id']?>"><?=$category['name']?></a>
            <?php } } ?>
    </div>
    
    <div class="content">
        <div class="search-box">
            <!--<h2 class="section-heading text-center mb-4">Search For Product</h2>-->
            <form action="search.php" method="get">
                <div class="input-group mb-5">
                    <input type="text" class="form-control" name="key" placeholder="Search books, authors, categories...">
                    <button class="btn btn-primary"><i class="fas fa-search"></i></button>
                </div>
            </form>
        </div>

        <!-- Hero Image Banner -->
        <div class="hero-banner">
            <div class="hero-content">
                <h2>Discover Your Next Favorite Book</h2>
                <p>Explore our vast collection of books across all genres and categories</p>
                
            </div>
        </div>

        <div class="featured-books">
            <h2 class="section-heading">Featured Books</h2>
            <div class="d-flex flex-wrap justify-content-center">
                <?php if ($books == 0) { ?>
                    <div class="alert alert-warning text-center p-5 w-100">
                        <img src="img/empty.png" width="100">
                        <br>There is no book in the database
                    </div>
                <?php } else { ?>
                    <?php foreach ($books as $book) { ?>
                        <div class="card m-3">
                            <img src="uploads/cover/<?=$book['cover']?>" class="card-img-top">
                            <div class="card-body">
                                <h5 class="card-title"><?=$book['title']?></h5>
                                <p class="card-text">
                                    <i><b>By: 
                                        <?php foreach($authors as $author){ 
                                            if ($author['id'] == $book['author_id']) echo $author['name'];
                                        } ?>
                                        <br>Category: 
                                        <?php foreach($categories as $category){ 
                                            if ($category['id'] == $book['category_id']) echo $category['name'];
                                        } ?>
                                    </b></i>
                                </p>
                                <a href="uploads/files/<?=$book['file']?>" class="btn btn-success">Open</a>
                                <a href="uploads/files/<?=$book['file']?>" class="btn btn-primary" download="<?=$book['title']?>">Download</a>
                            </div>
                        </div>
                    <?php } ?>
                <?php } ?>
            </div>
        </div>
    </div>
</body>
</html>