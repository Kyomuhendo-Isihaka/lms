<?php
session_start();

$sessionId = $_SESSION['id'] ?? '';
$id = $_REQUEST['id'] ?? 'dashboard';
$action = $_REQUEST['action'] ?? '';

if (!$sessionId) {
    header("location:login.php");
    die();
}

include("include/db_con.php");
include("data/get_data.php");

ob_start();



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Loan application and Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm"
        crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
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


    <nav class="navbar navbar-expand-md navbar-light bg_cream fixed-top">
        <div class="container text_maroon">
            <a class="navbar-brand" href="#">Online Loan management System</a>

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse  justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    <li class=" <?php if ('dashboard' == $id) {
                        echo "active";
                    } ?> nav-item">
                        <a href="my_account.php?id=dashboard" class="nav-link">Dashboard</a>
                    </li>


                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle <?php if ('loan_apply' == $id || 'loan_history' == $id) {
                            echo "active";
                        } ?> " href="#" id="servicesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false">
                            Loans
                        </a>
                        <div class="dropdown-menu" aria-labelledby="servicesDropdown">
                            <a class="dropdown-item" href="my_account.php?id=loan_apply">Apply</a>
                            <a class="dropdown-item" href="my_account.php?id=loan_history">Loan History</a>

                        </div>
                    </li>

                    <li class=" <?php if ('payments' == $id) {
                        echo "active";
                    } ?> nav-item">
                        <a href="my_account.php?id=payments" class="nav-link">Payments</a>
                    </li>
                    <li class=" <?php if ('profile' == $id) {
                        echo "active";
                    } ?> nav-item">
                        <a href="my_account.php?id=profile" class="nav-link">My Profile</a>
                    </li>


                    <li class="nav-item">
                        <a class="nav-lin btn bg_maroon text_cream" href="logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container-fluid mt-5">
        <div class="container main_body pt-5">
            <!-- --------------------------------------dashbaord-------------------------------------- -->
            <?php if ('dashboard' == $id) {

                ?>
                <div class="row">

                    <div class="col-md-4">
                        <div class="dbd-card bg_maroon  p-3" style=" border-radius: 15px; margin:10px;">
                            <h3 class="text_cream text-center">
                                <?php
                                $add = $conn->query("SELECT * FROM loan WHERE user_id = '$sessionId' && status='0'");
                                $num = $add->rowCount();
                                echo $num;
                                ?>
                            </h3>
                            <p class="text-center text-white">Pending Loans</p>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="dbd-card bg_maroon  p-3" style=" border-radius: 15px; margin:10px;">
                            <h3 class="text_cream text-center">
                                <?php
                                $add = $conn->query("SELECT * FROM loan WHERE user_id = '$sessionId' && status='1'");
                                $num = $add->rowCount();
                                echo $num;
                                ?>
                            </h3>
                            <p class="text-center text-white">Active Loans</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="dbd-card bg_maroon  p-3" style=" border-radius: 15px; margin:10px;">
                            <h3 class="text_cream text-center">
                                <?php
                                $add = $conn->query("SELECT * FROM payment WHERE user_id = '$sessionId'");
                                $num = $add->rowCount();
                                echo $num;
                                ?>
                            </h3>
                            <p class="text-center text-white">Payments</p>
                        </div>
                    </div>



                </div>
                <?php
            }
            ?>

            <!-- --------------------------------------profile-------------------------------------- -->
            <?php if ('profile' == $id) {

                $user = getUserById($sessionId, $conn);

                ?>
                <div class="container text-center w-50">
                    <div class="bg_white p-5">
                        <h4 class="text-center text_maroon">My profile</h4>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="justify-content-between d-flex">
                                    <h5>Full name:</h5>
                                    <p>
                                        <?= $user['firstname'] ?>
                                        <?= $user['lastname'] ?>
                                    </p>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="justify-content-between d-flex">
                                    <h5>Gender</h5>
                                    <p>
                                        <?= $user['gender'] ?>
                                    </p>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="justify-content-between d-flex">
                                    <h5>Date of Birth</h5>
                                    <p>
                                        <?= $user['date_of_birth'] ?>
                                    </p>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="justify-content-between d-flex">
                                    <h5>Nin Number</h5>
                                    <p>
                                        <?= $user['nin_num'] ?>
                                    </p>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="justify-content-between d-flex">
                                    <h5>Phone</h5>
                                    <p>
                                        <?= $user['phone'] ?>
                                    </p>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="justify-content-between d-flex">
                                    <h5>Email Address</h5>
                                    <p>
                                        <?= $user['email'] ?>
                                    </p>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="justify-content-between d-flex">
                                    <h5>Address</h5>
                                    <p>
                                        <?= $user['address'] ?>
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="justify-content-between d-flex">
                                    <h5>Password</h5>
                                    <p>*********** </p>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <?php printf("<a href='my_account.php?action=update_profile&id=%s' class='btn bg_maroon text_cream form-control'>Update Prrofile</a>", $user['id']) ?>

                            </div>
                        </div>

                    </div>
                </div>
                <?php
            }
            ?>
            <?php if ('update_profile' == $action) {
                $user_id = $_REQUEST['id'];
                $user = getUserById($user_id, $conn);
                ?>
                <div class="container p-3 w-75 my-4">
                    <div class="bg_white p-5">
                        <h3 class="text-center text_maroon">Edit Profile</h3>
                        <form action="data/add_data.php" method="POST">
                            <input type="hidden" name="user_id" value="<?= $user_id ?>">
                            <label>Firstname</label>
                            <input type="text" name="fname" class="form-control my-2" value="<?= $user['firstname'] ?>">

                            <label>Lastname</label>
                            <input type="text" name="lname" class="form-control my-2" value="<?= $user['lastname'] ?>">

                            <label>Phone Number</label>
                            <input type="text" name="phone" class="form-control my-2" value="<?= $user['phone'] ?>">

                            <label>Eail Address</label>
                            <input type="text" name="email" class="form-control my-2" value="<?= $user['email'] ?>">

                            <label>Address</label>
                            <input type="text" name="address" class="form-control my-2" value="<?= $user['address'] ?>">

                            <label>Old password</label>
                            <input type="password" name="old_pass" class="form-control my-2">

                            <label>New Password</label>
                            <input type="text" name="new_pass" class="form-control my-2">

                            <button type="submit" name="update_profile"
                                class="btn bg_maroon text_cream form-control my-3">Update Profile</button>
                        </form>
                    </div>
                </div>
                <?php
            } ?>


            <!-- --------------------------------------payments-------------------------------------- -->
            <?php if ('payments' == $id) {+
                $loans = getAllLoans($conn);

                ?>
                <div class="container">
                    <div class="bg_white p-3">
                        <h4 class="text-center text_maroon mb-5">Loan Payments</h4>
                        <h5 class="text-center text_maroon">Pending Loan Payments</h5>
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col">Loan Type</th>
                                    <th scope="col">Debt Amount(ugx)</th>
                                    <th scope="col">Paid Amount(ugx)</th>
                                    <th scope="col">Remaining Amount(ugx)</th>
                                    <th scope="col">Loan Status</th>
                                    <th scope="col">Make Payments</th>
                                </tr>

                            <tbody>
                                <?php if ($loans >= 1) {
                                    $loan_types = getLoanTypes($conn);
                                    foreach ($loans as $index => $loan) {
                                        if ($loan['user_id'] == $sessionId) {

                                            if ($loan['status'] == '1') {
                                                ?>
                                                <tr>

                                                    <td>
                                                        <?php foreach ($loan_types as $loan_type) {
                                                            if ($loan_type['id'] == $loan['loan_typeId']) {
                                                                echo $loan_type['type_name'];
                                                            }
                                                        } ?>
                                                    </td>

                                                    <td>
                                                        <?php
                                                        $debt_amount = $loan['loan_amount'] + $loan['intrest_amout'];
                                                        echo $debt_amount;
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <?= $loan['paid_amount'] ?>
                                                    </td>
                                                    <td>
                                                        <?php
                                                        $remaining_amount = $debt_amount - $loan['paid_amount'];
                                                        echo $remaining_amount;
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <?php
                                                        if ($loan['status'] == '0') {
                                                            echo "<p class='text-warning'>Pending</p>";
                                                        } elseif ($loan['status'] == '1') {
                                                            echo "<p class='text-success'>Active</p>";
                                                        } elseif ($loan['status'] == '-1') {
                                                            echo "<p class='text-secondary'>Canceled</p>";
                                                        }
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <a href='my_account.php?action=make_payment&id=<?= $loan['id'] ?>'
                                                            class='text_cream btn bg_maroon'>Pay</a>
                                                    </td>
                                                </tr>
                                                <?php
                                            }
                                        }
                                    }
                                } else {
                                    echo "<tr class='text-center'><td colspan='5'>No Running Loans</td></tr>";
                                }
                                ?>

                            </tbody>
                            </thead>
                        </table>



                        <hr>
                        <h5 class="text-center text_maroon"> Loan Payments History</h5>
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>

                                    <th scope="col">Paid Amount(ugx)</th>
                                    <th scope="col">Payment Date</th>


                                </tr>

                            <tbody>
                                <?php if ($loans >= 1) {
                                    $loan_types = getLoanTypes($conn);
                                    $payments = getAllpayments($conn);
                                    foreach ($payments as $payment) {
                                        if ($payment['user_id'] == $sessionId) {


                                            ?>
                                            <tr>

                                                <td>
                                                    <?= $payment['payment_amount'] ?>
                                                </td>
                                                <td>
                                                    <?= $payment['payment_date'] ?>
                                                </td>



                                            </tr>
                                            <?php


                                        }
                                    }
                                } else {
                                    echo "<tr class='text-center'><td colspan='5'>No Running Loans</td></tr>";
                                }
                                ?>

                            </tbody>
                            </thead>
                        </table>

                    </div>
                </div>
                <?php
            }

            ?>

            <?php if ('make_payment' == $action) {
                $loan_id = $_REQUEST['id'];
                $loan = getLoanById($loan_id, $conn);

                $total_debt = $loan['loan_amount'] + $loan['intrest_amout'];
                $remaining_amount = $total_debt - $loan['paid_amount'];
                ?>
                <div class="container w-75">
                    <div class="bg_white p-3">
                        <h4 class="text-center text_maroon">Make Payments</h4>
                        <div class="justify-content-between d-flex">
                            <h5>Total Loan Debt:</h5>
                            <p>
                                <?= $total_debt ?>ugx
                            </p>
                        </div>
                        <div class="justify-content-between d-flex">
                            <h5>Remaining Loan Debt:</h5>
                            <p>
                                <?= $remaining_amount ?>Ugx
                            </p>
                        </div>
                        <form action="data/add_data.php" class="mt-4" method="POST">
                            <input type="hidden" name="debt_amount" value="<?= $total_debt ?>" id="">
                            <input type="hidden" name="user_id" value="<?= $sessionId ?>" id="">
                            <input type="hidden" value="<?= $loan_id ?>" name="loan_id" id="">
                            <input type="hidden" value="<?= $loan['paid_amount'] ?>" name="paid_amount">

                            <div class="col-md-12">
                                <label>Select Payment Method</label><br>
                                <input type="radio" class="m-3" value="Bank" checked name="payment_method"> Bank 
                                <input type="radio" class="m-3" value="MTN"  name="payment_method"> MTN Mobile Money
                                <input type="radio" class="m-3" value="Airtel" name="payment_method"> Airtel Money
                                

                            </div>

                            <label for="">Enter amount You want to pay</label>
                            <input type="text" name="payment_amount" class="form-control my-2" id="">

                            <button type="submit" name="pay" class="btn bg_maroon text_cream form-control my-2">Make
                                Payment</button>
                        </form>
                    </div>
                </div>
                <?php
            } ?>

            <!-- --------------------------------------loan Apply------------------------------------- -->
            <?php if ('loan_apply' == $id) {
                $loan_types = getLoanTypes($conn);

                ?>
                <div class="bg_white p-5">
                    <h3 class="text-center text_maroon">Apply For A Loan</h3>
                    <form action="data/add_data.php" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="user_id" value="<?= $sessionId ?>" id="">
                        <div class="row my-3 ">
                            <div class="col-md-6">
                                <input type="text" name="fname" placeholder="First Name" class="form-control my-2" required>
                            </div>
                            <div class="col-md-6">
                                <input type="text" name="lname" placeholder="Last Name" class="form-control my-2" required>
                            </div>
                            <div class="col-md-12">
                                <input type="text" name="nin" placeholder="Nin Number" class="form-control my-2">
                            </div>
                            <div class="col-md-12">
                                <input type="text" name="phone" placeholder="Phone Number" class="form-control my-2"
                                    required>
                            </div>
                            <div class="col-md-12">
                                <input type="email" name="email" placeholder="Email Address" class="form-control my-2"
                                    required>
                            </div>

                            <div class="col-md-12">
                                <label>Loan Type</label><br>
                                <div class="row">
                                    <?php foreach ($loan_types as $loan_type) { ?>

                                        <div class="col-md-4">
                                            <input type="radio" class="m-3 loan-type" name="loan_type"
                                                data-interest-rate="<?= $loan_type['interest_rate'] ?>"
                                                data-max-loan-amount="<?= $loan_type['max_loan_amount'] ?>"
                                                data-loan-type-id="<?= $loan_type['id'] ?>">
                                            <?= $loan_type['type_name'] ?>
                                        </div>



                                    <?php } ?>

                                    <input type="hidden" name="loan_typeId" id="loan-type-id">
                                </div>
                            </div>


                            <div class="col-md-12">
                                <label>Loan period</label><br>
                                <select id="loan_period" name="loan_period" class="form-control my-3"
                                    onchange="calculateInterest()">
                                    <option value="3">Three Month</option>
                                    <option value="6">Six Month</option>
                                    <option value="12">One year</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label>Amount</label>
                                <input type="text" id="loan_amount" name="loan_amount" placeholder="Amount"
                                    class="form-control my-2" required oninput="calculateInterest()">
                            </div>
                            <div class="col-md-6">
                                <label for="">Interest</label>
                                <input type="text" id="interest_amount" name="interest_amount" readonly
                                    class="form-control my-2" required>
                            </div>

                            <div class="col-md-12 mt-2">
                                <label for="">Bank Statement</label>
                                <input type="file" name="bank_statement" placeholder="Bank Statement"
                                    class="form-control my-2" required>
                            </div>

                            <div class="col-md-12">
                                <div class="text-center">

                                    <button name="loan_apply" class="btn w-25 bg_maroon text_cream my-3">Submit</button>
                                </div>
                            </div>
                        </div>
                    </form>

                </div>
                <?php
            }

            ?>

            <!-- --------------------------------------loan History------------------------------------- -->
            <?php if ('loan_history' == $id) {
                $loans = getAllLoans($conn);


                ?>
                <div class="container w-75">
                    <div class="bg_white p-3">
                        <h4 class="text-center text_maroon">Loan History</h4>

                        <h5 class="text_maroon">Running Loans</h5>
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col">Loan Type</th>
                                    <th scope="col">Loan Amount(UGX)</th>
                                    <th scope="col">Interest Amount(ugx)</th>
                                    <th scope="col">Loan Status</th>
                                    <!-- <th scope="col">View more details</th> -->
                                </tr>

                            <tbody>
                                <?php if ($loans >= 1) {
                                    $loan_types = getLoanTypes($conn);
                                    foreach ($loans as $index => $loan) {
                                        if ($loan['user_id'] == $sessionId) {

                                            if ($loan['status'] == '1' || $loan['status'] == '0') {
                                                ?>
                                                <tr>

                                                    <td>
                                                        <?php foreach ($loan_types as $loan_type) {
                                                            if ($loan_type['id'] == $loan['loan_typeId']) {
                                                                echo $loan_type['type_name'];
                                                            }
                                                        } ?>
                                                    </td>
                                                    <td>
                                                        <?= $loan['loan_amount'] ?>
                                                    </td>
                                                    <td>
                                                        <?= $loan['intrest_amout'] ?>
                                                    </td>
                                                    <td>
                                                        <?php
                                                        if ($loan['status'] == '0') {
                                                            echo "<p class='text-warning'>Pending</p>";
                                                        } elseif ($loan['status'] == '1') {
                                                            echo "<p class='text-success'>Active</p>";
                                                        } elseif ($loan['status'] == '-1') {
                                                            echo "<p class='text-secondary'>Canceled</p>";
                                                        }
                                                        ?>
                                                    </td>
                                                    <!-- <td>
                                                        <a href='my_account.php?action=loan_details&id=<? ?>'
                                                            class='text_cream btn bg_maroon'>More</a>
                                                    </td> -->
                                                </tr>
                                                <?php
                                            }
                                        }
                                    }
                                } else {
                                    echo "<tr class='text-center'><td colspan='5'>No Running Loans</td></tr>";
                                }
                                ?>

                            </tbody>
                            </thead>
                        </table>

                        <hr>
                        <h5 class="text_maroon">Closed Loans</h5>
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col">Loan Type</th>
                                    <th scope="col">Loan Amount(UGX)</th>
                                    <th scope="col">Interest Amount(ugx)</th>
                                    <th scope="col">Loan Status</th>
                                    <!-- <th scope="col">View more details</th> -->
                                </tr>

                            <tbody>
                                <?php if ($loans >= 1) {
                                    $loan_types = getLoanTypes($conn);
                                    foreach ($loans as $index => $loan) {

                                        if ($loan['user_id'] == $sessionId) {

                                            if ($loan['status'] != '0' && $loan['status'] != '1') {
                                                ?>
                                                <tr>

                                                    <td>
                                                        <?php foreach ($loan_types as $loan_type) {
                                                            if ($loan_type['id'] == $loan['loan_typeId']) {
                                                                echo $loan_type['type_name'];
                                                            }
                                                        } ?>
                                                    </td>
                                                    <td>
                                                        <?= $loan['loan_amount'] ?>
                                                    </td>
                                                    <td>
                                                        <?= $loan['intrest_amout'] ?>
                                                    </td>
                                                    <td>
                                                        <?php
                                                        if ($loan['status'] == '0') {
                                                            echo "<p class='text-warning'>Pending</p>";
                                                        } elseif ($loan['status'] == '1') {
                                                            echo "<p class='text-success'>Active</p>";
                                                        } elseif ($loan['status'] == '-1') {
                                                            echo "<p class='text-secondary'>Canceled</p>";
                                                        }
                                                        ?>
                                                    </td>

                                                </tr>
                                                <?php
                                            }
                                        }
                                    }
                                } else {
                                    echo "<tr class='text-center'><td colspan='5'>No Running Loans</td></tr>";
                                }
                                ?>

                            </tbody>
                            </thead>
                        </table>


                    </div>
                </div>
                <?php
            }

            ?>
        </div>
    </div>

    <script>

        function calculateInterest() {
            // Get selected loan period and loan amount
            const loanPeriod = parseFloat(document.getElementById("loan_period").value);
            const loanAmount = parseFloat(document.getElementById("loan_amount").value);

            // Perform interest calculation
            const interestRate = 0.05
            const calculatedInterest = loanAmount * interestRate * (loanPeriod / 12);

            // Update the interest input field with the calculated interest
            document.getElementById("interest_amount").value = calculatedInterest.toFixed(2);
        }
    </script>

    <script>
        function updateMaxLoanAmountAndInterest() {
            // Get the selected loan type radio button
            const selectedLoanType = document.querySelector('input[name="loan_type"]:checked');
            const loanAmount = parseFloat(document.getElementById("loan_amount").value);

            // Update the maximum loan amount and interest fields based on the selected loan type
            if (selectedLoanType) {
                const loanPeriod = parseFloat(document.getElementById("loan_period").value);

                const maxLoanAmount = parseFloat(selectedLoanType.getAttribute("data-max-loan-amount"));
                const interestRate = parseFloat(selectedLoanType.getAttribute("data-interest-rate"));
                const loanTypeId = parseInt(selectedLoanType.getAttribute("data-loan-type-id"));

                document.getElementById("loan_amount").setAttribute("placeholder", "Amount (max=" + maxLoanAmount + ")");
                document.getElementById("interest_amount").value = (loanAmount * interestRate * (loanPeriod / 12)).toFixed(2);
                document.getElementById("loan-type-id").setAttribute("value", loanTypeId);
            }
        }

        // Add an event listener to the radio buttons to trigger the update function
        const loanTypeRadioButtons = document.querySelectorAll('.loan-type');
        loanTypeRadioButtons.forEach(function (radioButton) {
            radioButton.addEventListener('change', updateMaxLoanAmountAndInterest);
        });

        // Initial call to set the values based on the default selected loan type
        updateMaxLoanAmountAndInterest();
    </script>






    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


</body>

</html>