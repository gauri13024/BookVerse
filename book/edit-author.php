<?php  
session_start();

# If the admin is logged in
if (isset($_SESSION['user_id']) && isset($_SESSION['user_email'])) {
    
    # If author ID is not set
    if (!isset($_GET['id'])) {
        #Redirect to admin.php page
        header("Location: admin.php");
        exit;
    }

    $id = $_GET['id'];

    # Database Connection File
    include "db_conn.php";

    # author helper function
    include "php/func-author.php";
    $author = get_author($conn, $id);
    
    # If the ID is invalid
    if ($author == 0) {
        #Redirect to admin.php page
        header("Location: admin.php");
        exit;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Author - BookVerse Admin</title>

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

        .navbar-nav .nav-link:hover {
            color: white !important;
            transform: translateY(-2px);
        }

        /* Form Styling */
        .form-container {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            padding: 40px;
            margin-top: 30px;
            max-width: 600px;
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

        /* Responsive Adjustments */
        @media (max-width: 768px) {
            .form-container {
                padding: 25px;
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
            <a class="navbar-brand" href="admin.php">BookVerse Admin</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Store</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="add-book.php">Add Book</a>
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
            <form action="php/edit-author.php"
                  method="post">
                <h1 class="form-title">
                    <i class="fas fa-user-edit me-2"></i>Edit Author
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
                
                <input type="text" 
                       value="<?=$author['id']?>" 
                       hidden
                       name="author_id">

                <div class="mb-4">
                    <label class="form-label">
                        Author Name
                    </label>
                    <input type="text" 
                           class="form-control"
                           value="<?=$author['name']?>" 
                           name="author_name"
                           required>
                </div>

                <button type="submit" 
                        class="btn btn-primary mt-4">
                        <i class="fas fa-save me-2"></i>Update Author
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