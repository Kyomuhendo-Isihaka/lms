<?php
session_start();

include("include/db_con.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Loan Application and Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm"
        crossorigin="anonymous"></script>
    <link rel="stylesheet" href="assets/css/style.css">
    <script src="assets/js/swal.js"></script>
</head>

<body>
    <?php if (isset($_GET['success'])) { ?>
        <script>
            setTimeout(function () {
                swal("Success", "<?= $_GET['success'] ?>", "success");
            },
                100);
        </script>
        
    <?php } ?>
    <?php if (isset($_GET['error'])) { ?>
        <script>
            setTimeout(function () {
                swal("Failed", "<?= $_GET['error'] ?>", "error");
            },
                100);
        </script>
    <?php } ?>

    <div class="container p-5 mt-5 w-50">
        <div class="bg-light p-3">
            <h2 class="text-center">Admin Login</h2>
            <div class="text-center">
                <img src="assets/img/logo.png" alt="" height="200">
            </div>
            <?php
            if (isset($_POST['login'])) {
                $email = $_POST['email'];
                $pass = $_POST['pass'];

                $role = $_POST['role'];

                if ($email && $pass) {
                    $query = "SELECT * FROM {$role} WHERE email = '{$email}'";
                    $stmt = $conn->query($query);

                    $user = $stmt->fetch();
                    $_pass = $user['password'];
                    if(password_verify($pass, $_pass)){

                        $_SESSION['id'] = $user['id'];
                        $_SESSION['role'] = $user['role'];
                        header('location: index.php');
                    }else {
                        $err = "Wrong Email Address or Password";
                        header("location:login.php?error=$err");
                    }

                    
                }else {
                    $err = "Something went wrong";
                    header("location:login.php?error=$err");
                }

            }
            ?>
            <form method="POST">
                <div class="row my-3 ">
                    <div class="col-md-12">
                        <input type="text" name="email" placeholder="Email Adress" class="form-control my-2" required>
                    </div>
                    <div class="col-md-12">
                        <input type="password" name="pass" placeholder="Password" class="form-control my-2" required>
                    </div>
                    <div class="col-md-12">
                        <select name="role" class="form-control" id="">
                            <option value="employee">Administrator</option>
                            <option value="accountant">Accountant</option>
                        </select>
                    </div>
                    

                    <div class="col-md-12">
                        <div class="text-center">
                            <button type="submit" name="login" class="btn w-25 bg_cream text_maroon my-3">Login</button>
                        </div>
                    </div>
                </div>

            </form>

            <a href="reset_pass.php" class="text-center text_maroon nav-link">Forgot Password?</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.min.js"
        integrity="sha384-Rx+T1VzGupg4BHQYs2gCW9It+akI2MM/mndMCy36UVfodzcJcF0GGLxZIzObiEfa"
        crossorigin="anonymous"></script>
</body>

</html>