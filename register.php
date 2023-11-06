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
    <?php if (isset($_GET['error'])) { ?>
        <script>
            setTimeout(function () {
                swal("Failed", "<?= $_GET['error'] ?>", "error");
            },
                100);
        </script>
    <?php } ?>
    <div class="container p-5 mt-5">
        <div class="bg_white p-3">
            <h2 class="text-center">Register</h2>
            <form action="data/add_data.php" method="POST">
                <div class="row my-3 ">
                    <div class="col-md-6">
                        <input type="text" name="fname" placeholder="First Name" class="form-control my-2" required>
                    </div>
                    <div class="col-md-6">
                        <input type="text" name="lname" placeholder="Last Name" class="form-control my-2" required>
                    </div>
                    <div class="col-md-12">
                        <label>Gender</label><br>
                        <input type="radio" class="m-3" value="Male" checked name="gender"> Male
                        <input type="radio" class="m-3" value="Female" name="gender"> Female
                    </div>

                    <div class="col-md-12">
                        <label for="">Date of birth</label>
                        <input type="date" name="dob" placeholder="Date of birth" class="form-control my-2">
                    </div>
                    <div class="col-md-12">
                        <input type="text" name="fnumber" placeholder="Force Number" class="form-control my-2" required>
                    </div>
                    
                    <div class="col-md-12">
                        <select name="rank" class="form-control my-2" required>
                            <option value="">Select Rank</option>
                            <option value="CGP">CGP</option>
                            <option value="DCGP"> DCGP</option>
                            <option value="ACGP"> ACGP</option>
                            <option value="SCP" > SCP</option>
                            <option value="CP"> CP</option>
                            <option value="ACP" > ACP</option>
                            <option value="SSP" > SSP</option>
                            <option value="SP" > SP</option>
                            <option value="SASP"> SASP</option>
                            <option value="ASP" > ASP</option>
                            <option value="CASP"> CASP</option>
                            <option value="POI" > POI</option>
                            <option value="POII"> POII</option>
                            <option value="CPO" > CPO</option>
                            <option value="CHI" > CHI</option>
                            <option value="CHII"> CHII</option>
                            <option value="CHIIIk"> CHIII</option>
                            <option value="SGT" > SGT</option>
                            <option value="CPL" > CPL</option>
                            <option value="LCPL"> LCPL</option>
                            <option value="WDR" > WDR</option>
                        </select>
                    </div>
                    <div class="col-md-12">
                        <input type="text" name="nin" placeholder="Nin Number" class="form-control my-2">
                    </div>
                    <div class="col-md-12">
                        <input type="text" name="phone" placeholder="Phone Number" class="form-control my-2" required>
                    </div>
                    <div class="col-md-12">
                        <input type="email" name="email" placeholder="Email Address" class="form-control my-2" required>
                    </div>
                    <div class="col-md-12">
                        <input type="text" name="address" placeholder="Address" class="form-control my-2" required>
                    </div>
                    <div class="col-md-12">
                        <textarea name="user_info" id="" cols="30" rows="5" class="form-control my-2"
                            placeholder="Your other information...."></textarea>
                    </div>
                    <div class="col-md-12">
                        <input type="password" name="pass" placeholder="Password" minlength="6" class="form-control my-2" required>
                    </div>
                    <div class="col-md-12">
                        <input type="password" name="cf_pass" placeholder="Confirm Password" class="form-control my-2"
                            required>
                    </div>

                    <div class="col-md-12">
                        <div class="text-center">
                            <button type="submit" name="register"
                                class="btn w-25 bg_maroon text_cream my-3">Register</button>
                        </div>
                    </div>
                </div>

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