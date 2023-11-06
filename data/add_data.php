<?php
include("../include/db_con.php");
include("get_data.php");

//regestering user 
if (isset($_POST['register'])) {
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $dob = $_POST['dob'];
    $gender = $_POST['gender'];
    $fnumber = $_POST['fnumber'];
    $rank = $_POST['rank'];
    $nin = $_POST['nin'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $user_info = $_POST['user_info'];
    $pass = $_POST['pass'];
    $cf_pass = $_POST['cf_pass'];

    if ($fname && $lname && $dob && $gender && $fnumber && $rank && $nin && $phone && $email && $address && $user_info && $pass && $cf_pass) {
        if ($pass == $cf_pass) {

            $h_pass = password_hash($pass, PASSWORD_BCRYPT);

            $query = "INSERT INTO user( firstname, lastname, gender, date_of_birth, force_number, rank, nin_num, phone, email, address, user_info, password, status) VALUES('$fname', '$lname', '$gender', '$dob', '$fnumber', '$rank', '$nin', '$phone', '$email', '$address', '$user_info', '$h_pass', '0')";
            $stmt = $conn->query($query);
            if ($stmt == true) {
                $sm = "Registered successfully";
                header("location: ../login.php?success=$sm");
            } else {
                $err = "Registration Failed try again!";
                header("location: ../register.php?error=$err");
            }
        } else {
            $err = "Password don't match try again!";
            header("location: ../register.php?error=$err");
        }
    } else {
        $err = "Something went wrong";
        header("location: ../register.php?error=$err");
        exit;
    }


}

//loan_apply

if (isset($_POST['loan_apply'])) {
    $user_id = $_POST['user_id'];
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $nin = $_POST['nin'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $loan_typeId = $_POST['loan_typeId'];
    $loan_period = $_POST['loan_period'];
    $loan_amount = $_POST['loan_amount'];
    $interest_amount = $_POST['interest_amount'];

    $bank_statement = $_FILES['bank_statement']['name'];

    if ($user_id && $loan_typeId && $fname && $lname && $nin && $phone && $email && $loan_amount && $loan_period && $interest_amount && $bank_statement) {
        $bankStatement = $_FILES['bank_statement']['tmp_name'];
        move_uploaded_file($bankStatement, "../admin/assets/$bankStatement");

        $query = "INSERT INTO loan(user_id, loan_typeId, applicant_fname, applicant_lname, applicant_nin, applicant_phone, applicant_email, loan_amount, loan_period, intrest_amout, paid_amount, bank_statment, status) VALUES('$user_id','$loan_typeId','$fname','$lname','$nin','$phone','$email','$loan_amount','$loan_period','$interest_amount','0','$bank_statement','0')";

        $stmt = $conn->query($query);
        if ($stmt == true) {
            $sm = "Application Successfull you will be contacted soon";
            header("location: ../my_account.php?id=loan_apply&success=$sm");
            exit;
        } else {
            $err = "Something went wrong try again!";
            header("location: ../my_account.php?id=loan_apply&error=$err");
            exit;
        }

    } else {
        $err = "Something went wrong";
        header("location: ../my_account.php?id=loan_apply&error=$err");
        exit;
    }


}

//make payment
if (isset($_POST['pay'])) {
    $loan_id = $_POST['loan_id'];
    $user_id = $_POST['user_id'];
    $payment_amount = $_POST['payment_amount'];

    $total_debt = $_POST['debt_amount'];

    $paid_amount = $_POST['paid_amount'];

    if ($loan_id && $payment_amount) {

        $query = "INSERT INTO payment(loan_id, user_id, payment_amount) VALUES('$loan_id', '$user_id', '$payment_amount')";
        $stmt = $conn->query($query);

        $total_paidAmount = $paid_amount + $payment_amount;

        $sql = "UPDATE loan SET paid_amount='$total_paidAmount' WHERE id = '$loan_id'";
        $res = $conn->query($sql);

        if($total_paidAmount==$total_debt){
            $stmt = $conn->query("UPDATE loan SET status='-1' WHERE id = '$loan_id'");
            $sql = $conn->query("UPDATE user SET status='0' WHERE id = '$user_id'");

        }



        if ($stmt && $res) {
            $sm = "Payment Successful";
            header("location: ../my_account.php?id=payments&success=$sm");
            exit;
        } else {
            $err = "Something went wrong";
            header("location: ../my_account.php?id=payments&error=$err");
            exit;
        }

    } else {
        $err = "Something went wrong";
        header("location: ../my_account.php?id=payments&error=$err");
        exit;
    }
}

//update profile
if (isset($_POST['update_profile'])) {
    $user_id = $_POST['user_id'];
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $old_pass = $_POST['old_pass'];
    $new_pass = $_POST['new_pass'];

    if ($fname && $lname && $phone && $email && $address && $old_pass && $new_pass) {
        $user = getUserById($user_id, $conn);
        $_pass = $user['password'];

        if (password_verify($old_pass, $_pass)) {
            $h_pass = password_hash($new_pass, PASSWORD_BCRYPT);

            $query = "UPDATE user SET firstname='$fname', lastname='$lname', phone='$phone', email='$email', address='$address', password='$h_pass' WHERE id='$user_id'";
            $stmt = $conn->query($query);

            if ($stmt == true) {
                $sm = "Profile Updated";
                header("location: ../my_account.php?id=profile&success=$sm");
                exit;
            } else {
                $err = "Something went wrong";
                header("location: ../my_account.php?id=profile&error=$err");
                exit;
            }

        } else {
            $err = "Old password didn't match";
            header("location: ../my_account.php?id=profile&error=$err");
            exit;
        }


    } else {
        $err = "Something went wrong";
        header("location: ../my_account.php?id=profile&error=$err");
        exit;
    }


}
?>