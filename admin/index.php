<?php
session_start();

$sessionId = $_SESSION['id'] ?? '';
$role = $_SESSION['role'] ?? '';
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
    <title>Online Loan Application and Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous">
        </script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <script src="assets/js/swal.js"></script>
</head>

<body>
    <!-- --------------------------------sidebar ------------------------------------------ -->
    <div class="sidebar bg_maroon">
        <h5 class="text-center"><?php
        $employee = getEmployeeById($sessionId, $role, $conn);
        $r = "";
        if ($employee['role'] == 'employee') {
            $r = 'Admin';
        } elseif ($employee['role'] == 'accountant') {
            $r = 'Accountant';
        }
        echo $employee['firstname'] . " " . $employee['lastname'] . "(" . $r . ")";

        ?></h5>
        <ul class="">
            <li class=" <?php if ('dashboard' == $id) {
                echo "active";
            } ?>">
                <a href="index.php?id=dashboard" class="nav-link">Dashboard</a>
            </li>

            <?php if ($role == 'employee') { ?>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle <?php if ('add_accountant' == $id || 'all_accountant' == $id) {
                        echo "active";
                    } ?> " href="#" id="accountantDropdown" role="button" data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false">
                        Accountants
                    </a>
                    <div class="dropdown-menu" aria-labelledby="accountantDropdown">
                        <a class="dropdown-item" href="index.php?id=add_accountant">Add Accountant</a>
                        <a class="dropdown-item" href="index.php?id=all_accountant">All Accountants</a>

                    </div>
                </li>
            <?php } ?>

            <li class=" <?php if ('borrowers' == $id) {
                echo "active";
            } ?>">
                <a href="index.php?id=borrowers" class="nav-link">Borrowers</a>
            </li>

            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle <?php if ('add_loanType' == $id || 'all_loanType' == $id) {
                    echo "active";
                } ?> " href="#" id="loanTypeDropdown" role="button" data-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false">
                    LoansTypes
                </a>
                <div class="dropdown-menu" aria-labelledby="loanTypeDropdown">
                    <a class="dropdown-item" href="index.php?id=add_loanType">Add Loan Type</a>
                    <a class="dropdown-item" href="index.php?id=all_loanType">All Loan Type</a>

                </div>
            </li>

            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="loanDropdown" role="button" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">
                    Loans
                </a>
                <div class="dropdown-menu" aria-labelledby="loanDropdown">
                    <a class="dropdown-item" href="index.php?id=pending_loans">Pending Loans</a>
                    <a class="dropdown-item" href="index.php?id=all_loans">All loans</a>
                </div>
            </li>

            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle <?php if ('pending_payments' == $id || 'cleared_payments' == $id) {
                    echo "active";
                } ?> " href="#" id="paymentsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false">
                    Payments
                </a>
                <div class="dropdown-menu" aria-labelledby="paymentsDropdown">
                    <a class="dropdown-item" href="index.php?id=pending_payments">Pending payments</a>
                    <a class="dropdown-item" href="index.php?id=cleared_payments">cleared_payments</a>

                </div>
            </li>
            <li class=" <?php if ('settings' == $id) {
                echo "active";
            } ?>">
                <a href="index.php?id=settings" class="nav-link">Settings</a>
            </li>

        </ul>
    </div>

    <!-- --------------------------------topbar------------------------------------------------- -->

    <div class="topbar">

        <div class="p-3 bg_white">
         
            <p class="text-end text_maroon"><a href="logout.php" class="nav-link">Logout</a></p>
                          
        </div>
    </div>
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
    <!-- ---------------------------------------end topbar ---------------------------------------- -->

    <div class="container-fluid">
        <div class="dashboard  p-5">
            <div class="container">
                <!-- --------------------------------dashboard ------------------------------------->
                <?php if ('dashboard' == $id) {
                    ?>

                <div class="row">
                    <div class="col-md-4">
                        <div class="dbd-card bg_maroon  p-3" style=" border-radius: 15px; margin:10px;">
                            <h3 class="text_cream text-center">
                                <?php
                                $add = $conn->query("SELECT * FROM user");
                                $num = $add->rowCount();
                                echo $num;
                                ?>
                            </h3>
                            <p class="text-center text-white">Borrowers</p>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="dbd-card bg_maroon  p-3" style=" border-radius: 15px; margin:10px;">
                            <h3 class="text_cream text-center">
                                <?php
                                $add = $conn->query("SELECT * FROM loan");
                                $num = $add->rowCount();
                                echo $num;
                                ?>
                            </h3>
                            <p class="text-center text-white">Loans</p>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="dbd-card bg_maroon  p-3" style=" border-radius: 15px; margin:10px;">
                            <h3 class="text_cream text-center">
                                <?php
                                $add = $conn->query("SELECT * FROM loan WHERE status='0'");
                                $num = $add->rowCount();
                                echo $num;
                                ?>
                            </h3>
                            <p class="text-center text-white">Pending loans</p>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="dbd-card bg_maroon  p-3" style=" border-radius: 15px; margin:10px;">
                            <h3 class="text_cream text-center">
                                <?php
                                $add = $conn->query("SELECT * FROM loan WHERE status='1'");
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
                                $add = $conn->query("SELECT * FROM loan WHERE status='-1'");
                                $num = $add->rowCount();
                                echo $num;
                                ?>
                            </h3>
                            <p class="text-center text-white">Canceled Loans</p>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="dbd-card bg_maroon  p-3" style=" border-radius: 15px; margin:10px;">
                            <h3 class="text_cream text-center">
                                <?php
                                $add = $conn->query("SELECT * FROM payment");
                                $num = $add->rowCount();
                                echo $num;
                                ?>
                            </h3>
                            <p class="text-center text-white">payments</p>
                        </div>
                    </div>


                </div>

                <?php } ?>

                <!-- --------------------------------Accountants ------------------------------------->
                <?php if ('add_accountant' == $id) {
                    ?>
                <div class="bg_white p-5 w-75 ml-5">

                    <h3 class="text-center text_maroon">Add Accountant </h3>
                    <form action="data/add_data.php" method="POST">
                        <input type="text" name="fname" class="form-control my-3" placeholder="First Name" required>
                        <input type="text" name="lname" class="form-control my-3"
                            placeholder="Last Name" required>
                        <input type="text" name="phone" class="form-control my-3"
                            placeholder="Phone Number" required>

                            <input type="email" name="email" class="form-control my-3"
                            placeholder="Email Address" required>

                            <input type="password" minlength="6" name="password" class="form-control my-3"
                            placeholder="Password" required>
                       
                        <button type="submit" name="add_accountant"
                            class="btn bg_maroon text_cream form-control my-3">Add</button>

                    </form>
                </div>
                <?php } ?>

                <?php if ('all_accountant' == $id) {
                    $accountants = getAllAccountants($conn);
                    ?>
                <div class="bg_white p-5">
                    <h3 class="text-center text_maroon">Accountants</h3>

                    <table class="table table-striped table-bordered">
                        <tr><a href="index.php?id=add_accountant" class="btn bg_cream text_maroon float-end mb-3">Add
                                Accountant</a>
                        </tr>
                        <thead class="bg_maroon">
                            <tr>
                                <th scope="col">Name</th>
                                <th scope="col">Phone</th>
                                <th scope="col">Email Address</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            if ($accountants > 0) {
                                foreach ($accountants as $index => $accountant) {
                                    ?>
                            <tr>
                                <td>
                                    <?= $accountant['firstname'] ?> <?= $accountant['lastname'] ?>
                                </td>
                                <td>
                                <?= $accountant['phone'] ?>
                                </td>
                                <td>
                                <?= $accountant['email'] ?>
                                </td>
                                <td>

                                    
                                    <?php printf("<a href='index.php?action=edit_accountant&id=%s' class='text_cream'><i class='fas fa-edit p-2'></i></a>", $accountant['id']) ?>
                                    <button class="btn text-danger" data-bs-toggle="modal"
                                        data-bs-target="#delete_accountant<?= $index ?>"><i
                                            class="fa fa-trash"></i></button>
                                </td>
                            </tr>
                            <!-- -------delete loan type popup -------- -->
                                                                <div class="modal fade" id="delete_accountant<?= $index ?>" tabindex="-1" aria-hidden="true">
                                                                    <div class="modal-dialog modal-dialog-centered">
                                                                        <div class="modal-content">
                                                                            <div class="modal-body text-center">
                                                                                <p>Do you want to Delete this Accountant</p>
                                                                                <form action="data/add_data.php" method="POST">
                                                                                    <input name="accountant_id" type="text" value="<?= $accountant['id'] ?>"
                                                                                        hidden>
                                                                                    <div class="text-center p-3">
                                                                                        <button type="button" class="btn m-4 bg_blue"
                                                                                            data-bs-dismiss="modal">No</button>
                                                                                        <button type="submit" name="delete_accountant" class="btn btn-danger"
                                                                                            id="confirmButton">Yes</button>
                                                                                    </div>
                                                                                </form>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                    <?php }
                            } else {
                                echo "<tr>No Accountant Available</tr>";
                            } ?>
                                    </tbody>
                                </table>

                            </div>
                <?php } ?>

                <?php if ('edit_accountant' == $action) {
                    $id = $_REQUEST['id'];

                    $accountant = getAccountantById($id, $conn);
                    ?>
                            <div class="bg_white p-5 w-75 ml-5">

                                <h3 class="text-center text_maroon">Edit Accountant </h3>
                                <form action="data/add_data.php" method="POST">
                                    <input type="hidden" name="accountant_id" value="<?= $id ?>">
                                    <input type="text" value="<?= $accountant['firstname'] ?>" name="fname"
                                        class="form-control my-3" placeholder="First Name" required>
                                    <input type="text" value="<?= $accountant['lastname'] ?>" name="lname"
                                        class="form-control my-3" placeholder="Last Name" required>
                                    <input type="text" value="<?= $accountant['phone'] ?>" name="phone"
                                        class="form-control my-3" placeholder="Phone" required>
                                        <input type="email" value="<?= $accountant['email'] ?>" name="email"
                                        class="form-control my-3" placeholder="Email" required>
                               
                                        <input type="password" name="password"
                                        class="form-control my-3" minlength="6" placeholder="Password" required>
                               
                                    <button type="submit" name="update_accountant"
                                        class="btn bg_maroon text_cream form-control my-3">Update</button>

                                </form>
                            </div>
                <?php } ?>

                <!-- --------------------------------Borrowers ------------------------------------->
                <?php if ('borrowers' == $id) {
                    $borrowers = getAllBorrowers($conn);
                    ?>
                <div class="bg_white p-5">
                    <h4 class="text-center text_maroon">Borrowers</h4>
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">Name</th>
                                <th scope="col">Phone</th>
                                <th scope="col">Adress</th>
                                <th scope="col">Loan Status</th>
                                <th scope="col">View more details</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            if ($borrowers > 0) {
                                foreach ($borrowers as $index => $borrower) {
                                    ?>
                            <tr>
                                <td>
                                    <?= $borrower['firstname'] ?>
                                    <?= $borrower['lastname'] ?>
                                </td>
                                <td>
                                    <?= $borrower['phone'] ?>
                                </td>
                                <td>
                                    <?= $borrower['address'] ?>
                                </td>
                                <td>
                                    <?php if ($borrower['status'] == '0') {
                                        echo "<p class='text-secondary'>In-active</p>";
                                    } else {
                                        echo "<p class='text-success'>Active</p>";
                                    } ?>
                                </td>
                                <td>
                                    <?php printf("<a href='index.php?action=borrower_details&id=%s' class='text_cream'><i class='fas fa-eye p-2'></i></a>", $borrower['id']) ?>
                                </td>
                            </tr>
                            <?php
                                }
                            } else {
                                echo "<tr>No Borrowers Found</tr>";
                            }
                            ?>
                        </tbody>

                    </table>
                </div>

                <?php } ?>

                <?php if ('borrower_details' == $action) {
                    $borrower_id = $_REQUEST['id'];
                    $borrower = getBorrowerById($borrower_id, $conn);
                    ?>
                <div class="container w-75">
                    <div class="bg_white p-3">
                        <h5 class="text-center text_maroon">Borrower Details</h5>
                        <div class="justify-content-between d-flex">
                            <h6>Full Name:</h6>
                            <p>
                                <?= $borrower['firstname'] ?>
                                <?= $borrower['lastname'] ?>
                            </p>
                        </div>


                        <div class="justify-content-between d-flex">
                            <h6>Gender:</h6>
                            <p>
                                <?= $borrower['gender'] ?>
                            </p>
                        </div>


                        <div class="justify-content-between d-flex">
                            <h6>Date of Birth</h6>
                            <p>
                                <?= $borrower['date_of_birth'] ?>
                            </p>
                        </div>

                        <div class="justify-content-between d-flex">
                            <h6>Nin number:</h6>
                            <p>
                                <?= $borrower['nin_num'] ?>
                            </p>
                        </div>

                        <div class="justify-content-between d-flex">
                            <h6>Force number:</h6>
                            <p>
                                <?= $borrower['force_number'] ?>
                            </p>
                        </div>

                        <div class="justify-content-between d-flex">
                            <h6>Phone:</h6>
                            <p>
                                <?= $borrower['phone'] ?>
                            </p>
                        </div>
                        <div class="justify-content-between d-flex">
                            <h6>Email Address:</h6>
                            <p>
                                <?= $borrower['email'] ?>
                            </p>
                        </div>

                        <div class="justify-content-between d-flex">
                            <h6>Address:</h6>
                            <p>
                                <?= $borrower['address'] ?>
                            </p>
                        </div>

                        <div class="justify-content-between d-flex">
                            <h6>Loan Status:</h6>
                            <?php if ($borrower['status'] == '0') {
                                echo "<p class='text-success'>No Active Loan</p>";
                            } else {
                                echo "<p class='text-danger'>Has Active Loan</p>";
                            } ?>
                        </div>

                    </div>
                </div>
                <?php } ?>

                <!-- --------------------------------Loan type ------------------------------------->
                <?php if ('add_loanType' == $id) {
                    ?>
                <div class="bg_white p-5 w-75 ml-5">

                    <h3 class="text-center text_maroon">Add LoanType </h3>
                    <form action="data/add_data.php" method="POST">
                        <input type="text" name="type_name" class="form-control my-3" placeholder="Type Name" required>
                        <input type="text" name="max_loan_amount" class="form-control my-3"
                            placeholder="Max Loan Amount" required>
                        <input type="text" name="intrest_rate" class="form-control my-3"
                            placeholder="Intrest Rate(e.g 0.3)" required>
                        <textarea name="loan_description" id="" cols="30" rows="10" class="form-control my-3"
                            placeholder="Loan Description" required></textarea>
                        <button type="submit" name="add_loanType"
                            class="btn bg_maroon text_cream form-control my-3">Add</button>

                    </form>
                </div>
                <?php } ?>

                <?php if ('all_loanType' == $id) {
                    $loan_types = getLoanTypes($conn);
                    ?>
                <div class="bg_white p-5">
                    <h3 class="text-center text_maroon">Loan Types</h3>

                    <table class="table table-striped table-bordered">
                        <tr><a href="index.php?id=add_loanType" class="btn bg_cream text_maroon float-end mb-3">Add
                                LoanType</a>
                        </tr>
                        <thead class="bg_maroon">
                            <tr>
                                <th scope="col">Type Name</th>
                                <th scope="col">Max Loan Amout(Ugx)</th>
                                <th scope="col">Interest Rate(%)</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            if ($loan_types > 0) {
                                foreach ($loan_types as $index => $loan_type) {
                                    ?>
                            <tr>
                                <td>
                                    <?= $loan_type['type_name'] ?>
                                </td>
                                <td>
                                    <?= $loan_type['max_loan_amount'] ?>
                                </td>
                                <td>
                                    <?= $loan_type['interest_rate'] ?>
                                </td>
                                <td>

                                    <button class="btn text-secondary" data-bs-toggle="modal"
                                        data-bs-target="#view_loanType<?= $index ?>"><i class="fa fa-eye"></i></button>

                                    <?php printf("<a href='index.php?action=edit_loanType&id=%s' class='text_cream'><i class='fas fa-edit p-2'></i></a>", $loan_type['id']) ?>

                                    <button class="btn text-danger" data-bs-toggle="modal"
                                        data-bs-target="#delete_loanType<?= $index ?>"><i
                                            class="fa fa-trash"></i></button>
                                </td>
                            </tr>
                            <div class="modal fade" id="view_loanType<?= $index ?>" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-body">
                                            <div class="row p-2">
                                                <h4 class="text-center text_maroon">
                                                    <?= $loan_type['type_name'] ?>
                                                </h4>

                                                <div class="col col-12 justify-content-between d-flex">
                                                    <h5>Maximum Loan Amount</h5>
                                                    <p>
                                                        <?= $loan_type['max_loan_amount'] ?>Ugx
                                                    </p>
                                                </div>
                                                <div class="col col-12 justify-content-between d-flex">
                                                    <h6>Interest Rate</h6>
                                                    <p>
                                                        <?= $loan_type['interest_rate'] ?>%
                                                    </p>
                                                </div>

                                                <div class="col col-12 ">
                                                    <h5>Loan Description</h5>
                                                    <p>
                                                        <?= $loan_type['loan_description'] ?>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- -------delete loan type popup -------- -->
                                                                <div class="modal fade" id="delete_loanType<?= $index ?>" tabindex="-1" aria-hidden="true">
                                                                    <div class="modal-dialog modal-dialog-centered">
                                                                        <div class="modal-content">
                                                                            <div class="modal-body text-center">
                                                                                <p>Do you want to Delete this LoanType</p>
                                                                                <form action="data/add_data.php" method="POST">
                                                                                    <input name="loan_type_id" type="text" value="<?= $loan_type['id'] ?>"
                                                                                        hidden>
                                                                                    <div class="text-center p-3">
                                                                                        <button type="button" class="btn m-4 bg_blue"
                                                                                            data-bs-dismiss="modal">No</button>
                                                                                        <button type="submit" name="delete_loanType" class="btn btn-danger"
                                                                                            id="confirmButton">Yes</button>
                                                                                    </div>
                                                                                </form>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                    <?php }
                            } else {
                                echo "<tr>No Loan Types Available</tr>";
                            } ?>
                                    </tbody>
                                </table>

                            </div>
                <?php } ?>

                <?php if ('edit_loanType' == $action) {
                    $id = $_REQUEST['id'];

                    $loan_type = getLoanTypeById($id, $conn);
                    ?>
                            <div class="bg_white p-5 w-75 ml-5">

                                <h3 class="text-center text_maroon">Edit LoanType </h3>
                                <form action="data/add_data.php" method="POST">
                                    <input type="hidden" name="loanType_id" value="<?= $id ?>">
                                    <input type="text" value="<?= $loan_type['type_name'] ?>" name="type_name"
                                        class="form-control my-3" placeholder="Type Name" required>
                                    <input type="text" value="<?= $loan_type['max_loan_amount'] ?>" name="max_loan_amount"
                                        class="form-control my-3" placeholder="Max Loan Amount" required>
                                    <input type="text" value="<?= $loan_type['interest_rate'] ?>" name="intrest_rate"
                                        class="form-control my-3" placeholder="Intrest Rate(e.g 0.3)" required>
                                    <textarea name="loan_description" cols="30" rows="10" class="form-control my-3"
                                        placeholder="Loan Description" required><?= $loan_type['loan_description'] ?></textarea>
                                    <button type="submit" name="update_loanType"
                                        class="btn bg_maroon text_cream form-control my-3">Update</button>

                                </form>
                            </div>
                <?php } ?>

                <!-- -----------------------------------loans-------------------------------------- -->
                <?php if ('pending_loans' == $id) {
                    $loans = getAllLoans($conn);
                    ?>

                            <div class="bg_white p-5">
                                <h4 class="text-center text_maroon">Pending Loans</h4>
                                <table class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th scope="col">Borrower Name</th>
                                            <th scope="col">Loan Type</th>
                                            <th scope="col">Loan Amount(UGX)</th>
                                            <th scope="col">Loan Status</th>
                                            <th scope="col">View more details</th>
                                        </tr>

                                    <tbody>
                                        <?php
                                        if ($loans >= 1) {
                                            foreach ($loans as $index => $loan) {
                                                $borrower = getBorrowerById($loan['user_id'], $conn);
                                                $loan_type = getLoanTypeById($loan['loan_typeId'], $conn);

                                                if ($loan['status'] == '0') {
                                                    ?>
                                                                            <tr>

                                                                                <td>
                                                                                    <?= $borrower['firstname'] ?>
                                                                                    <?= $borrower['lastname'] ?>
                                                                                </td>
                                                                                <td>
                                                                                    <?= $loan_type['type_name'] ?>
                                                                                </td>
                                                                                <td>
                                                                                    <?= $loan['loan_amount'] ?>
                                                                                </td>
                                                                                <td>
                                                                                    <?php if ($loan['status'] == '0') {
                                                                                        echo "<p class='text-warning'>Pending</p>";
                                                                                    } elseif ($loan['status'] == '1') {
                                                                                        echo "<p class='text-success'>Active</p>";
                                                                                    } elseif ($loan['status'] == '-1') {
                                                                                        echo "<p class='text-secondary'>Canceled</p>";
                                                                                    } ?>
                                                                                </td>
                                                                                <td>
                                                                                    <?php printf("<a href='index.php?action=loan_deatils&id=%s' class='text_cream btn bg_maroon'>More</a>", $loan['id']) ?>
                                                                                </td>
                                                                            </tr>
                                                                            <?php
                                                }
                                            }
                                        } else {
                                            echo "<tr>
                                        <td col='5'>No Pending Loans</td>
                                    </tr>";
                                        }
                                        ?>
                                    </tbody>
                                    </thead>
                                </table>
                            </div>
                            <?php
                }

                ?>
                <?php if ('loan_deatils' == $action) {
                    $loan_id = $_REQUEST['id'];

                    $loan = getLoanById($loan_id, $conn);
                    $loan_type = getLoanTypeById($loan['loan_typeId'], $conn);
                    $borrower = getBorrowerById($loan['user_id'], $conn);
                    ?>
                            <div class="container w-75">
                                <div class="bg_white p-5">
                                    <h4 class="text-center text_maroon">Loan Application</h4>
                                    <h5 class="text_maroon">Borrowers Details</h5>

                                    <div class="justify-content-between d-flex">
                                        <h6>Full Name:</h6>
                                        <p>
                                            <?= $borrower['firstname'] ?>
                                            <?= $borrower['lastname'] ?>
                                        </p>
                                    </div>


                                    <div class="justify-content-between d-flex">
                                        <h6>Gender:</h6>
                                        <p>
                                            <?= $borrower['gender'] ?>
                                        </p>
                                    </div>


                                    <div class="justify-content-between d-flex">
                                        <h6>Date of Birth</h6>
                                        <p>
                                            <?= $borrower['date_of_birth'] ?>
                                        </p>
                                    </div>

                                    <div class="justify-content-between d-flex">
                                        <h6>Nin number:</h6>
                                        <p>
                                            <?= $borrower['nin_num'] ?>
                                        </p>
                                    </div>

                                    <div class="justify-content-between d-flex">
                                        <h6>Force number:</h6>
                                        <p>
                                            <?= $borrower['force_number'] ?>
                                        </p>
                                    </div>

                                    <div class="justify-content-between d-flex">
                                        <h6>Phone:</h6>
                                        <p>
                                            <?= $borrower['phone'] ?>
                                        </p>
                                    </div>
                                    <div class="justify-content-between d-flex">
                                        <h6>Email Address:</h6>
                                        <p>
                                            <?= $borrower['email'] ?>
                                        </p>
                                    </div>

                                    <div class="justify-content-between d-flex">
                                        <h6>Address:</h6>
                                        <p>
                                            <?= $borrower['address'] ?>
                                        </p>
                                    </div>

                                    <div class="justify-content-between d-flex">
                                        <h6>Loan Status:</h6>
                                        <?php if ($borrower['status'] == '0') {
                                            echo "<p class='text-success'>No Active Loan</p>";
                                        } else {
                                            echo "<p class='text-danger'>Has Active Loan</p>";
                                        } ?>
                                    </div>


                                    <hr>
                                    <h5 class="text_maroon">Loan Details</h5>

                                    <div class="justify-content-between d-flex">
                                        <h6>Application Name:</h6>
                                        <p>
                                            <?= $loan['applicant_fname'] ?>
                                            <?= $loan['applicant_lname'] ?>
                                        </p>
                                    </div>

                                    <div class="justify-content-between d-flex">
                                        <h6>Application Phone:</h6>
                                        <p>
                                            <?= $loan['applicant_phone'] ?>
                                        </p>
                                    </div>

                                    <div class="justify-content-between d-flex">
                                        <h6>Applicantion Email:</h6>
                                        <p>
                                            <?= $loan['applicant_email'] ?>
                                        </p>
                                    </div>

                                    <div class="justify-content-between d-flex">
                                        <h6>Loan Type:</h6>
                                        <p>
                                            <?= $loan_type['type_name'] ?>
                                        </p>
                                    </div>

                                    <div class="justify-content-between d-flex">
                                        <h6>Loan Amount:</h6>
                                        <p>
                                            <?= $loan['loan_amount'] ?>Ugx
                                        </p>
                                    </div>

                                    <div class="justify-content-between d-flex">
                                        <h6>Loan Period:</h6>
                                        <p>
                                            <?= $loan['loan_period'] ?> Month
                                        </p>
                                    </div>

                                    <div class="justify-content-between d-flex">
                                        <h6>Loan Interest:</h6>
                                        <p>
                                            <?= $loan['intrest_amout'] ?>Ugx
                                        </p>
                                    </div>

                                    <div class="justify-content-between d-flex">
                                        <h6>Bank Statement:</h6>
                                        <p>
                                            <?= $loan['bank_statment'] ?>
                                        </p>
                                    </div>
                                    <?php if ($loan['status'] == '0') { ?>
                                                <div class="text-center">


                                                    <button data-bs-toggle="modal" data-bs-target="#cancel_application"
                                                        class="btn bg-secondary text_cream w-25">Cancel</button>

                                                    <button data-bs-toggle="modal" data-bs-target="#approve_application"
                                                        class="btn bg-success text_cream w-25">Approve</button>


                                                </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- --------------------cancel application popup--------------------- -->
                    <div class="modal fade" id="cancel_application" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-body text-center">
                                    <p>Do you want to Reject this Application</p>
                                    <form action="data/add_data.php" method="POST">
                               
                                        <input name="loan_id" type="text" value="<?= $loan['id'] ?>" hidden>
                                        <div class="text-center p-3">
                                            <button type="button" class="btn m-4 bg_blue" data-bs-dismiss="modal">No</button>
                                            <button type="submit" name="cancel_application" class="btn btn-danger"
                                                id="confirmButton">Yes</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- --------------------Approve application popup--------------------- -->
                    <div class="modal fade" id="approve_application" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-body text-center">
                                    <p>Do you want to Approve this Application</p>
                                    <form action="data/add_data.php" method="POST">
                                    <input type="hidden" name="user_id" value="<?= $borrower['id'] ?>" >
                                        <input name="loan_id" type="text" value="<?= $loan['id'] ?>" hidden>
                                        <div class="text-center p-3">
                                            <button type="button" class="btn m-4 bg_blue" data-bs-dismiss="modal">No</button>
                                            <button type="submit" name="approve_application" class="btn btn-danger"
                                                id="confirmButton">Yes</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <?php
                } ?>

    <?php if ('all_loans' == $id) {
        $loans = getAllLoans($conn);



        ?>
                <div class="bg_white p-5">
                    <h4 class="text-center text_maroon">Loans</h4>
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">Borrower Name</th>
                                <th scope="col">Loan Type</th>
                                <th scope="col">Loan Amount(UGX)</th>
                                <th scope="col">Loan Status</th>
                                <th scope="col">View more details</th>
                            </tr>

                        <tbody>
                            <?php foreach ($loans as $index => $loan) {
                                $borrower = getBorrowerById($loan['user_id'], $conn);
                                $loan_type = getLoanTypeById($loan['loan_typeId'], $conn);
                                ?>
                                        <tr>
                                            <? ?>
                                            <td>
                                                <?= $borrower['firstname'] ?>
                                                <?= $borrower['lastname'] ?>
                                            </td>
                                            <td>
                                                <?= $loan_type['type_name'] ?>
                                            </td>
                                            <td>
                                                <?= $loan['loan_amount'] ?>
                                            </td>
                                            <td>
                                                <?php if ($loan['status'] == '0') {
                                                    echo "<p class='text-warning'>Pending</p>";
                                                } elseif ($loan['status'] == '1') {
                                                    echo "<p class='text-success'>Active</p>";
                                                } elseif ($loan['status'] == '-1') {
                                                    echo "<p class='text-secondary'>Canceled</p>";
                                                } ?>
                                            </td>
                                            <td>
                                                <?php printf("<a href='index.php?action=loan_deatils&id=%s' class='text_cream btn bg_maroon'>More</a>", $loan['id']) ?>
                                            </td>
                                        </tr>
                                        <?php
                            }
                            ?>
                        </tbody>
                        </thead>
                    </table>
                </div>
                <?php
    }

    ?>

    <!-- -----------------------------------------payments--------------------------- -->
    <?php if ('pending_payments' == $id) {
        $loans = getAllLoans($conn);



        ?>
                <div class="bg_white p-3">
                    <h4 class="text-center text_maroon">Loan Payments</h4>
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">Borrower Name</th>
                                <th scope="col">Loan Type</th>
                                <th scope="col">Loan Amount(UGX)</th>
                                <th scope="col">Paid Amount(UGX)</th>
                                <th scope="col">Remaining Amount(UGX)</th>
                                <th scope="col">Loan Status</th>
                                <th scope="col">View pay details</th>
                            </tr>

                        <tbody>
                            <?php foreach ($loans as $index => $loan) {
                                $total_debt = $loan['loan_amount'] + $loan['intrest_amout'];
                                $remaining_amount = $total_debt - $loan['paid_amount'];

                                if ($loan['status'] == '1') {
                                    if ($remaining_amount != '0') {

                                        $borrower = getBorrowerById($loan['user_id'], $conn);
                                        $loan_type = getLoanTypeById($loan['loan_typeId'], $conn);
                                        ?>
                                                                <tr>
                                                                    <? ?>
                                                                    <td>
                                                                        <?= $borrower['firstname'] ?>
                                                                        <?= $borrower['lastname'] ?>
                                                                    </td>
                                                                    <td>
                                                                        <?= $loan_type['type_name'] ?>
                                                                    </td>
                                                                    <td>
                                                                        <?= $total_debt ?>
                                                                    </td>
                                                                    <td>
                                                                        <?= $loan['paid_amount'] ?>
                                                                    </td>
                                                                    <td>
                                                                        <?= $remaining_amount ?>
                                                                    </td>
                                                                    <td>
                                                                        <p class="text-success">Active</p>
                                                                    </td>
                                                                    <td>
                                                                        <?php printf("<a href='index.php?action=payment_deatils&id=%s' class='text_cream btn bg_maroon'>More</a>", $loan['id']) ?>
                                                                    </td>
                                                                </tr>
                                                                <?php
                                    }
                                }
                            }
                            ?>
                        </tbody>
                        </thead>
                    </table>
                </div>
                <?php
    }
    ?>

    <?php if ('cleared_payments' == $id) {
        $loans = getAllLoans($conn);



        ?>
                <div class="bg_white p-3">
                    <h4 class="text-center text_maroon">Cleared Loans</h4>
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">Borrower Name</th>
                                <th scope="col">Loan Type</th>
                                <th scope="col">Loan Amount(UGX)</th>
                                <th scope="col">Paid Amount(UGX)</th>
                                <th scope="col">Remaining Amount(UGX)</th>
                                <th scope="col">Loan Status</th>
                                <th scope="col">View pay details</th>
                            </tr>

                        <tbody>
                            <?php foreach ($loans as $index => $loan) {
                                $total_debt = $loan['loan_amount'] + $loan['intrest_amout'];
                                $remaining_amount = $total_debt - $loan['paid_amount'];

                                if ($loan['status'] == '-1') {
                                    if ($remaining_amount <= '0') {

                                        $borrower = getBorrowerById($loan['user_id'], $conn);
                                        $loan_type = getLoanTypeById($loan['loan_typeId'], $conn);
                                        ?>
                                                                <tr>
                                                                    <? ?>
                                                                    <td>
                                                                        <?= $borrower['firstname'] ?>
                                                                        <?= $borrower['lastname'] ?>
                                                                    </td>
                                                                    <td>
                                                                        <?= $loan_type['type_name'] ?>
                                                                    </td>
                                                                    <td>
                                                                        <?= $total_debt ?>
                                                                    </td>
                                                                    <td>
                                                                        <?= $loan['paid_amount'] ?>
                                                                    </td>
                                                                    <td>
                                                                        <?= $remaining_amount ?>
                                                                    </td>
                                                                    <td>
                                                                        <p class="text-success">Cleared</p>
                                                                    </td>
                                                                    <td>
                                                                        <?php printf("<a href='index.php?action=payment_deatils&id=%s' class='text_cream btn bg_maroon'>More</a>", $loan['id']) ?>
                                                                    </td>
                                                                </tr>
                                                                <?php
                                    }
                                }
                            }
                            ?>
                        </tbody>
                        </thead>
                    </table>
                </div>
                <?php
    }
    ?>

    <?php if ('payment_deatils' == $action) {
        $loan_id = $_REQUEST['id'];
        $payments = getAllpayments($conn);

        ?>
                <div class="bg_white p-3">
                    <h5 class="text-center text_maroon">Payment trends</h5>
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">Paid Amount(ugx)</th>
                                <th scope="col">Payment Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($payments as $payment) {
                                if ($payment['loan_id'] == $loan_id) {

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
                            } ?>
                        </tbody>
                    </table>

                </div>

                <?php
    }
    ?>

    <!-- ------------------------------------ settings------------------------------------ -->
    <?php if ('settings' == $id) {
        $employee = getEmployeeById($sessionId, $role, $conn);

        ?>
                <div class="container text-center w-50">
                    <div class="bg_white p-5">
                        <h4 class="text-center text_maroon">My profile</h4>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="justify-content-between d-flex">
                                    <h5>Full name:</h5>
                                    <p>
                                        <?= $employee['firstname'] ?>
                                        <?= $employee['lastname'] ?>
                                    </p>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="justify-content-between d-flex">
                                    <h5>Phone</h5>
                                    <p>
                                        <?= $employee['phone'] ?>
                                    </p>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="justify-content-between d-flex">
                                    <h5>Email</h5>
                                    <p>
                                        <?= $employee['email'] ?>
                                    </p>
                                </div>
                            </div>



                            <div class="col-md-12">
                                <div class="justify-content-between d-flex">
                                    <h5>Position</h5>
                                    <p>
                                        <?= $employee['role'] ?>
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
                                <?php printf("<a href='index.php?action=update_profile&id=%s' class='btn bg_maroon text_cream form-control'>Update Profile</a>", $employee['id']) ?>

                            </div>
                        </div>

                    </div>
                </div>
                <?php
    } ?>
    <?php if ('update_profile' == $action) {
        $employee_id = $_REQUEST['id'];

        $employee = getEmployeeById($employee_id, $role, $conn);

        ?>
                <div class="container p-3 w-75 my-4">
                    <div class="bg_white p-5">
                        <h3 class="text-center text_maroon">Edit Profile</h3>
                        <form action="data/add_data.php" method="POST">
                            <input type="hidden" name="employee_id" value="<?= $employee_id ?>">
                            <input type="hidden" name="role" value="<?= $employee['role'] ?>" id="">
                            <label>Firstname</label>
                            <input type="text" name="fname" class="form-control my-2" value="<?= $employee['firstname'] ?>">

                            <label>Lastname</label>
                            <input type="text" name="lname" class="form-control my-2" value="<?= $employee['lastname'] ?>">

                            <label>Phone Number</label>
                            <input type="text" name="phone" class="form-control my-2" value="<?= $employee['phone'] ?>">

                            <label>Eail Address</label>
                            <input type="text" name="email" class="form-control my-2" value="<?= $employee['email'] ?>">


                            <label>Old password</label>
                            <input type="password" name="old_pass" class="form-control my-2">

                            <label>New Password</label>
                            <input type="password" name="new_pass" class="form-control my-2">

                            <button type="submit" name="update_profile" class="btn bg_maroon text_cream form-control my-3">Update
                                Profile</button>
                        </form>
                    </div>
                </div>
                <?php
    }

    ?>


    </div>
    </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


</body>

</html>
