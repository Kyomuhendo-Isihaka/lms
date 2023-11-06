<?php
session_start();

include("../include/db_con.php");

include("get_data.php");

//add accountant
if(isset($_POST['add_accountant'])){
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $pass = $_POST['password'];

    if($fname && $lname && $phone && $email && $pass){
        $h_pass = password_hash($pass, PASSWORD_BCRYPT);
        $query = "INSERT INTO accountant(firstname, lastname, phone, email, password) VALUES('$fname', '$lname', '$phone', '$email', '$h_pass')";
        $stmt = $conn->query($query);

        if ($stmt == true) {
            $sm = "Accountant was added";
            header("location: ../index.php?id=add_accountant&success=$sm");
            exit;
        } else {
            $err = "Something went wrong";
            header("location: ../index.php?id=add_accountant&error=$err");
            exit;
        }

    }else {
        $err = "Something went wrong";
        header("location: ../index.php?id=add_accountant&error=$err");
        exit;
    }

}

//update accountant
if(isset($_POST['update_accountant'])){
    $id = $_POST['accountant_id'];
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $pass = $_POST['password'];

    if($fname && $lname && $phone && $email && $pass){
        $h_pass = password_hash($pass, PASSWORD_BCRYPT);
        $query = "UPDATE accountant SET firstname='$fname', lastname='$lname', phone='$phone', email='$email', password='$h_pass' WHERE id = '$id'";
        $stmt = $conn->query($query);

        if ($stmt == true) {
            $sm = "Accountant was Updated";
            header("location: ../index.php?id=all_accountant&success=$sm");
            exit;
        } else {
            $err = "Something went wrong";
            header("location: ../index.php?id=all_accountant&error=$err");
            exit;
        }

    }else {
        $err = "Something went wrong";
        header("location: ../index.php?id=all_accountant&error=$err");
        exit;
    }
}

//delete accountant
if (isset($_POST['delete_accountant'])) {
    $id = $_POST['accountant_id'];
    if ($id) {
        $query = "DELETE FROM accountant WHERE id = '$id'";
        $stmt = $conn->query($query);

        if ($stmt == true) {
            $sm = "Accountant was Deleted";
            header("location: ../index.php?id=all_accountant&success=$sm");
            exit;
        } else {
            $err = "Something went wrong";
            header("location: ../index.php?id=all_accountant&error=$err");
            exit;
        }
    }else {
        $err = "Something went wrong";
        header("location: ../index.php?id=all_accountant&error=$err");
        exit;
    }
}

//add loan type
if (isset($_POST['add_loanType'])) {
    $type_name = $_POST['type_name'];
    $max_loan_amount = $_POST['max_loan_amount'];
    $interest_rate = $_POST['intrest_rate'];
    $loan_description = $_POST['loan_description'];

    if ($type_name && $max_loan_amount && $interest_rate && $loan_description) {
        $query = "INSERT INTO loan_type(type_name, loan_description, interest_rate, max_loan_amount) VALUES('$type_name', '$loan_description','$interest_rate','$max_loan_amount')";
        $stmt = $conn->query($query);

        if ($stmt == true) {
            $sm = "LoanType was added";
            header("location: ../index.php?id=add_loanType&success=$sm");
            exit;
        } else {
            $err = "Something went wrong";
            header("location: ../index.php?id=add_loanType&error=$err");
            exit;
        }
    } else {
        $err = "Something went wrong";
        header("location: ../index.php?id=add_loanType&error=$err");
        exit;
    }
}

//update loan type
if (isset($_POST['update_loanType'])) {
    $id = $_POST['loanType_id'];
    $type_name = $_POST['type_name'];
    $max_loan_amount = $_POST['max_loan_amount'];
    $interest_rate = $_POST['intrest_rate'];
    $loan_description = $_POST['loan_description'];

    if ($type_name && $max_loan_amount && $interest_rate && $loan_description) {
        $query = "UPDATE loan_type SET type_name='$type_name', loan_description='$loan_description', interest_rate='$interest_rate', max_loan_amount='$max_loan_amount' WHERE id = '$id'";
        $stmt = $conn->query($query);

        if ($stmt == true) {
            $sm = "LoanType was updated";
            header("location: ../index.php?id=all_loanType&success=$sm");
            exit;
        } else {
            $err = "Something went wrong";
            header("location: ../index.php?id=all_loanType&error=$err");
            exit;
        }
    } else {
        $err = "Something went wrong";
        header("location: ../index.php?id=all_loanType&error=$err");
        exit;
    }
}
//delete loan type
if (isset($_POST['delete_loanType'])) {
    $id = $_POST['loan_type_id'];
    if ($id) {
        $query = "DELETE FROM loan_type WHERE id = '$id'";
        $stmt = $conn->query($query);

        if ($stmt == true) {
            $sm = "LoanType was Deleted";
            header("location: ../index.php?id=all_loanType&success=$sm");
            exit;
        } else {
            $err = "Something went wrong";
            header("location: ../index.php?id=all_loanType&error=$err");
            exit;
        }
    }else {
        $err = "Something went wrong";
        header("location: ../index.php?id=all_loanType&error=$err");
        exit;
    }
}
//approve loan application
if (isset($_POST['approve_application'])) {
    $loan_id = $_POST['loan_id'];
    $user_id = $_POST['user_id'];
    if ($loan_id) {
        $query = "UPDATE loan SET status='1' WHERE id='$loan_id'";
        $stmt = $conn->query($query);

        $conn->query("UPDATE user SET status='1' WHERE id='$user_id'");

        if ($stmt == true) {
            $sm = "Loan Application Approved";
            header("location: ../index.php?id=pending_loans&success=$sm");
            exit;
        } else {
            $err = "Something went wrong";
            header("location: ../index.php?id=pending_loans&error=$err");
            exit;
        }
    } else {
        $err = "Something went wrong";
        header("location: ../index.php?id=pending_loans&error=$err");
        exit;
    }
}

//cancel loan application
if (isset($_POST['cancel_application'])) {
    $loan_id = $_POST['loan_id'];
    if ($loan_id) {
        $query = "UPDATE loan SET status='-1' WHERE id='$loan_id'";
        $stmt = $conn->query($query);

        if ($stmt == true) {
            $sm = "Loan Application Canceled";
            header("location: ../index.php?id=pending_loans&success=$sm");
            exit;
        } else {
            $err = "Something went wrong";
            header("location: ../index.php?id=pending_loans&error=$err");
            exit;
        }
    } else {
        $err = "Something went wrong";
        header("location: ../index.php?id=pending_loans&error=$err");
        exit;
    }
}

//update profile
if (isset($_POST['update_profile'])) {
    $employee_id = $_POST['employee_id'];
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $old_pass = $_POST['old_pass'];
    $new_pass = $_POST['new_pass'];

    $role = $_POST['role'];

    if ($fname && $lname && $phone && $email && $old_pass && $new_pass) {
        $employee = getEmployeeById($employee_id, $role, $conn);
        $_pass = $employee['password'];

        if (password_verify($old_pass, $_pass)) {
            $h_pass = password_hash($new_pass, PASSWORD_BCRYPT);

            $query = "UPDATE {$role} SET firstname='$fname', lastname='$lname', phone='$phone', email='$email', password='$h_pass' WHERE id='$employee_id'";
            $stmt = $conn->query($query);

            if ($stmt == true) {
                $sm = "Profile Updated";
                header("location: ../index.php?id=settings&success=$sm");
                exit;
            } else {
                $err = "Something went wrong";
                header("location: ../index.php?id=settings&error=$err");
                exit;
            }

        } else {
            $err = "Old password didn't match";
            header("location: ../index.php?id=settings&error=$err");
            exit;
        }


    } else {
        $err = "Something went wrong ";
        header("location: ../index.php?id=settings&error=$err");
        exit;
    }


}
?>