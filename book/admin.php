<?php  
session_start();
# Admin
# If the admin is logged in
if (isset($_SESSION['user_id']) && isset($_SESSION['user_email'])) {
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
    <title>ADMIN PANEL</title>

    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        :root {
            --navbar-color: rgb(10, 203, 183); /* Your specified color for navbar and table headings */
            --sidebar-color: hsl(170, 100%, 28.6%); /* Your specified color for sidebar */
            --accent: #e67e22;
            --light: #f5f7fa;
            --dark: #2c3e50;
            --text: #34495e;
        }
        
        body {
            background-color: var(--light);
            font-family: 'Poppins', sans-serif;
            color: var(--text);
        }
        
        /* Navbar Styling */
        .navbar {
            background-color: var(--navbar-color);
            height: 80px;
            padding: 15px 30px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .navbar-brand {
            font-size: 24px;
            font-weight: bold;
            color: white !important;
            letter-spacing: 1px;
        }

        .navbar-nav .nav-link {
            color: rgba(255,255,255,0.9) !important;
            font-size: 16px;
            padding: 10px 20px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .navbar-nav .nav-link:hover {
            color: white !important;
            transform: translateY(-2px);
        }

        /* Sidebar (Admin Menu) */
        .admin-sidebar {
            width: 250px;
            background-color: var(--sidebar-color);
            color: white;
            position: fixed;
            height: 100%;
            padding-top: 20px;
            left: 0;
            top: 80px;
            box-shadow: 2px 0 15px rgba(0,0,0,0.1);
            z-index: 100;
        }

        .admin-sidebar h3 {
            font-size: 18px;
            font-weight: 600;
            padding: 15px 20px;
            border-bottom: 1px solid rgba(255,255,255,0.2);
            margin-bottom: 15px;
            color: white;
        }

        .admin-sidebar a {
            padding: 12px 25px;
            display: block;
            color: rgba(255,255,255,0.9);
            text-decoration: none;
            transition: all 0.3s ease;
            font-size: 15px;
            border-left: 3px solid transparent;
        }

        .admin-sidebar a:hover {
            background-color: rgba(255,255,255,0.1);
            color: white;
            border-left: 3px solid white;
        }

        /* Main Content */
        .admin-content {
            margin-left: 270px;
            padding: 30px;
            margin-top: 80px;
        }

        /* Table Headings */
        .table th {
            background-color: var(--navbar-color);
            color: white;
            font-weight: 600;
        }

        /* Rest of your existing styles... */
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
            background-color: var(--navbar-color);
            border: none;
            color: white;
        }

        .section-heading {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 30px;
            color: var(--dark);
            position: relative;
            padding-bottom: 10px;
        }

        .section-heading:after {
            content: '';
            position: absolute;
            left: 0;
            bottom: 0;
            width: 50px;
            height: 3px;
            background-color: var(--navbar-color);
        }

        .table {
            background-color: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        }

        .book-cover {
            width: 80px;
            height: 100px;
            object-fit: cover;
            border-radius: 4px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        .btn-warning {
            background-color: var(--accent);
            border: none;
            color: white;
        }

        .btn-warning:hover {
            background-color: #d35400;
            color: white;
        }

        .btn-danger {
            background-color: #e74c3c;
            border: none;
        }

        .btn-danger:hover {
            background-color: #c0392b;
        }

        .alert {
            border-radius: 8px;
        }

        @media (max-width: 992px) {
            .admin-sidebar {
                display: none;
            }
            .admin-content {
                margin-left: 0;
            }
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="admin.php">BookVerse Admin</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">View Store</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    
    <div class="admin-sidebar">
        <h3>Admin Menu</h3>
        <a href="admin.php"><i class="fas fa-tachometer-alt me-2"></i>Dashboard</a>
        <a href="add-book.php"><i class="fas fa-book me-2"></i>Add Book</a>
        <a href="add-category.php"><i class="fas fa-tags me-2"></i>Add Category</a>
        <a href="add-author.php"><i class="fas fa-user-edit me-2"></i>Add Author</a>
        <a href="#books-section"><i class="fas fa-book-open me-2"></i>Manage Books</a>
        <a href="#categories-section"><i class="fas fa-list me-2"></i>Manage Categories</a>
        <a href="#authors-section"><i class="fas fa-users me-2"></i>Manage Authors</a>
    </div>
    
    <div class="admin-content">
        <!-- Rest of your content remains the same -->
        <div class="search-box">
            <form action="search.php" method="get">
                <div class="input-group mb-5">
                    <input type="text" class="form-control" name="key" placeholder="Search books...">
                    <button class="btn"><i class="fas fa-search"></i></button>
                </div>
            </form>
        </div>

        <?php if (isset($_GET['error'])) { ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?=htmlspecialchars($_GET['error']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php } ?>
        <?php if (isset($_GET['success'])) { ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?=htmlspecialchars($_GET['success']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php } ?>

        <!-- Books Section -->
        <section id="books-section" class="mb-5">
            <h2 class="section-heading">Manage Books</h2>
            <?php if ($books == 0) { ?>
                <div class="alert alert-warning text-center p-5">
                    <img src="img/empty.png" width="100">
                    <br>
                    There are no books in the database
                </div>
            <?php } else { ?>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th width="5%">#</th>
                                <th width="25%">Title</th>
                                <th width="15%">Author</th>
                                <th width="25%">Description</th>
                                <th width="15%">Category</th>
                                <th width="15%">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 0; foreach ($books as $book) { $i++; ?>
                            <tr>
                                <td><?=$i?></td>
                                <td>
                                    <img class="book-cover me-2" src="uploads/cover/<?=$book['cover']?>">
                                    <a class="link-dark" href="uploads/files/<?=$book['file']?>">
                                        <?=$book['title']?>
                                    </a>
                                </td>
                                <td>
                                    <?php 
                                    if ($authors == 0) {
                                        echo "Undefined";
                                    } else { 
                                        foreach ($authors as $author) {
                                            if ($author['id'] == $book['author_id']) {
                                                echo $author['name'];
                                            }
                                        }
                                    }
                                    ?>
                                </td>
                                <td><?=substr($book['description'], 0, 50)?>...</td>
                                <td>
                                    <?php 
                                    if ($categories == 0) {
                                        echo "Undefined";
                                    } else { 
                                        foreach ($categories as $category) {
                                            if ($category['id'] == $book['category_id']) {
                                                echo $category['name'];
                                            }
                                        }
                                    }
                                    ?>
                                </td>
                                <td>
                                    <a href="edit-book.php?id=<?=$book['id']?>" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <a href="php/delete-book.php?id=<?=$book['id']?>" class="btn btn-sm btn-danger">
                                        <i class="fas fa-trash"></i> Delete
                                    </a>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            <?php } ?>
        </section>

        <!-- Categories Section -->
        <section id="categories-section" class="mb-5">
            <h2 class="section-heading">Manage Categories</h2>
            <?php if ($categories == 0) { ?>
                <div class="alert alert-warning text-center p-5">
                    <img src="img/empty.png" width="100">
                    <br>
                    There are no categories in the database
                </div>
            <?php } else { ?>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th width="5%">#</th>
                                <th width="75%">Category Name</th>
                                <th width="20%">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $j = 0; foreach ($categories as $category) { $j++; ?>
                            <tr>
                                <td><?=$j?></td>
                                <td><?=$category['name']?></td>
                                <td>
                                    <a href="edit-category.php?id=<?=$category['id']?>" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <a href="php/delete-category.php?id=<?=$category['id']?>" class="btn btn-sm btn-danger">
                                        <i class="fas fa-trash"></i> Delete
                                    </a>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            <?php } ?>
        </section>

        <!-- Authors Section -->
        <section id="authors-section">
            <h2 class="section-heading">Manage Authors</h2>
            <?php if ($authors == 0) { ?>
                <div class="alert alert-warning text-center p-5">
                    <img src="img/empty.png" width="100">
                    <br>
                    There are no authors in the database
                </div>
            <?php } else { ?>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th width="5%">#</th>
                                <th width="75%">Author Name</th>
                                <th width="20%">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $k = 0; foreach ($authors as $author) { $k++; ?>
                            <tr>
                                <td><?=$k?></td>
                                <td><?=$author['name']?></td>
                                <td>
                                    <a href="edit-author.php?id=<?=$author['id']?>" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <a href="php/delete-author.php?id=<?=$author['id']?>" class="btn btn-sm btn-danger">
                                        <i class="fas fa-trash"></i> Delete
                                    </a>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            <?php } ?>
        </section>
    </div>
</body>
</html>

<?php } else {
  header("Location: login.php");
  exit;
} ?>