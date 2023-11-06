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
            <h2 class="text-center">Forgot Password</h2>
            <?php
            if (isset($_POST['reset'])) {
                $email = $_POST['email'];
                $new_pass = $_POST['new_pass'];
                $conf_pass = $_POST['conf_pass'];

                $role = $_POST['role'];

                if ($email && $role) {
                    $query = "SELECT * FROM {$role} WHERE email = '$email'";
                    $stmt = $conn->query($query);
                    $user = $stmt->fetch();

                    $_email = $user['email'];
                    if ($email == $_email) {
                        if ($new_pass == $conf_pass) {
                            $h_pass = password_hash($new_pass, PASSWORD_BCRYPT);
                            $conn->query("UPDATE {$role} SET password='$h_pass' WHERE email='$email'");
                            header("location:login.php");

                        } else {
                            $err = "Password Don't match";
                            header("location:reset_pass.php?error=$err");
                            exit;
                        }
                    } else {
                        $err = "Email doesn't exist";
                        header("location:reset_pass.php?error=$err");
                        exit;
                    }
                }
            }
            ?>

            <form method="POST">
                <div class="row my-3 ">
                    <div class="col-md-12">
                        <select name="role" class="w-100 p-2 my-2">
                            <option value="">Select Role</option>
                            <option value="employee">Administrator</option>
                            <option value="accountant">Accountant</option>
                        </select>
                    </div>
                    <div class="col-md-12">
                        <input type="text" name="email" placeholder="Email Adress" class="form-control my-2" required>
                    </div>
                    <div class="col-md-12">
                        <input type="password" name="new_pass" placeholder="New Password" minlength="6"
                            class="form-control my-2" required>
                    </div>

                    <div class="col-md-12">
                        <input type="password" name="conf_pass" placeholder="Confirm Password" class="form-control my-2"
                            required>
                    </div>

                    <div class="col-md-12">
                        <div class="text-center">
                            <button type="submit" name="reset" class="btn w-25 bg_cream text_maroon my-3">Reset
                                Password</button>
                        </div>
                    </div>
                </div>
                <a href="login.php" class="text-center nav-link text_maroon">Back to Login</a>

            </form>
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