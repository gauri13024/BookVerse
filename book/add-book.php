<?php  
session_start();
# add book 
# If the admin is logged in
if (isset($_SESSION['user_id']) && isset($_SESSION['user_email'])) {
    # Database Connection File
    include "db_conn.php";

    # Category helper function
    include "php/func-category.php";
    $categories = get_all_categories($conn);

    # author helper function
    include "php/func-author.php";
    $authors = get_all_author($conn);

    if (isset($_GET['title'])) {
        $title = $_GET['title'];
    } else $title = '';

    if (isset($_GET['desc'])) {
        $desc = $_GET['desc'];
    } else $desc = '';

    if (isset($_GET['category_id'])) {
        $category_id = $_GET['category_id'];
    } else $category_id = 0;

    if (isset($_GET['author_id'])) {
        $author_id = $_GET['author_id'];
    } else $author_id = 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Book</title>

    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        :root {
            --navbar-color: rgb(10, 203, 183);
            --sidebar-color: hsl(170, 100%, 28.6%);
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

        .navbar-nav .nav-link.active {
            color: white !important;
            font-weight: 600;
        }

        .navbar-nav .nav-link:hover {
            color: white !important;
            transform: translateY(-2px);
        }

        /* Form Styling */
        .form-container {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            padding: 30px;
            margin-top: 30px;
            max-width: 700px;
            margin-left: auto;
            margin-right: auto;
        }

        .form-title {
            color: var(--navbar-color);
            font-weight: 700;
            margin-bottom: 30px;
            text-align: center;
            position: relative;
            padding-bottom: 15px;
        }

        .form-title:after {
            content: '';
            position: absolute;
            left: 50%;
            bottom: 0;
            width: 80px;
            height: 3px;
            background-color: var(--navbar-color);
            transform: translateX(-50%);
        }

        .form-label {
            font-weight: 600;
            color: var(--dark);
            margin-bottom: 8px;
        }

        .form-control {
            border-radius: 5px;
            padding: 12px;
            border: 1px solid #ddd;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: var(--navbar-color);
            box-shadow: 0 0 0 0.25rem rgba(10, 203, 183, 0.25);
        }

        .btn-primary {
            background-color: var(--navbar-color);
            border: none;
            padding: 12px 30px;
            font-weight: 600;
            border-radius: 5px;
            transition: all 0.3s ease;
            width: 100%;
        }

        .btn-primary:hover {
            background-color: #08b3a0;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .alert {
            border-radius: 5px;
        }

        select.form-control {
            appearance: none;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23343a40' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M2 5l6 6 6-6'/%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right 0.75rem center;
            background-size: 16px 12px;
        }

        /* Responsive Adjustments */
        @media (max-width: 768px) {
            .form-container {
                padding: 20px;
                margin-top: 20px;
            }
            
            .form-title {
                font-size: 24px;
            }
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="admin.php">BookVerse   Admin</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Store</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="add-book.php">Add Book</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="add-category.php">Add Category</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="add-author.php">Add Author</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="form-container">
            <form action="php/add-book.php"
                  method="post"
                  enctype="multipart/form-data">
                <h1 class="form-title">
                    Add New Book
                </h1>
                
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
                
                <div class="mb-4">
                    <label class="form-label">
                        Book Title
                    </label>
                    <input type="text" 
                           class="form-control"
                           value="<?=$title?>" 
                           name="book_title"
                           required>
                </div>

                <div class="mb-4">
                    <label class="form-label">
                        Book Description
                    </label>
                    <textarea class="form-control" 
                              name="book_description"
                              rows="3"><?=$desc?></textarea>
                </div>

                <div class="mb-4">
                    <label class="form-label">
                        Book Author
                    </label>
                    <select name="book_author"
                            class="form-control"
                            required>
                        <option value="0">
                            Select author
                        </option>
                        <?php 
                        if ($authors != 0) {
                            foreach ($authors as $author) { 
                                if ($author_id == $author['id']) { ?>
                                    <option selected value="<?=$author['id']?>">
                                        <?=$author['name']?>
                                    </option>
                                <?php } else { ?>
                                    <option value="<?=$author['id']?>">
                                        <?=$author['name']?>
                                    </option>
                                <?php } 
                            } 
                        } ?>
                    </select>
                </div>

                <div class="mb-4">
                    <label class="form-label">
                        Book Category
                    </label>
                    <select name="book_category"
                            class="form-control"
                            required>
                        <option value="0">
                            Select category
                        </option>
                        <?php 
                        if ($categories != 0) {
                            foreach ($categories as $category) { 
                                if ($category_id == $category['id']) { ?>
                                    <option selected value="<?=$category['id']?>">
                                        <?=$category['name']?>
                                    </option>
                                <?php } else { ?>
                                    <option value="<?=$category['id']?>">
                                        <?=$category['name']?>
                                    </option>
                                <?php } 
                            } 
                        } ?>
                    </select>
                </div>

                <div class="mb-4">
                    <label class="form-label">
                        Book Cover
                    </label>
                    <input type="file" 
                           class="form-control" 
                           name="book_cover"
                           required
                           accept="image/*">
                    <small class="text-muted">Upload a cover image (JPG, PNG, etc.)</small>
                </div>

                <div class="mb-4">
                    <label class="form-label">
                        Book File
                    </label>
                    <input type="file" 
                           class="form-control" 
                           name="file"
                           required
                           accept=".pdf,.epub,.doc,.docx">
                    <small class="text-muted">Upload the book file (PDF, EPUB, DOC, etc.)</small>
                </div>

                <button type="submit" 
                        class="btn btn-primary mt-3">
                        <i class="fas fa-plus-circle me-2"></i>Add Book
                </button>
            </form>
        </div>
    </div>
</body>
</html>

<?php } else {
    header("Location: login.php");
    exit;
} ?>