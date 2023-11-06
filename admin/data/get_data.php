<?php 
//get all accountants
function getAllAccountants($conn){
    $query = "SELECT * FROM accountant";
    $stmt = $conn->query($query);

    if($stmt == true){
        $accountants = $stmt->fetchAll();
        return $accountants;
    }else{
        return 0;
    }
}

//get accountant by id
function getAccountantById($loanType_id, $conn){
    $sql = "SELECT * FROM accountant WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$loanType_id]);

    if($stmt->rowCount()==1){
        $accountant = $stmt->fetch();
        return $accountant;
    }else{
        return 0;
    }
}
//get all borrowers
function getAllBorrowers($conn){
    $query = "SELECT * FROM user";
    $stmt = $conn->query($query);

    if($stmt == true){
        $borrowers = $stmt->fetchAll();
        return $borrowers;
    }else{
        return 0;
    }
}

//get borrower by id
function getBorrowerById($borrower_id, $conn){
    $sql = "SELECT * FROM user WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$borrower_id]);

    if($stmt->rowCount()==1){
        $borrower = $stmt->fetch();
        return $borrower;
    }else{
        return 0;
    }
}


//get all loanTypes
function getLoanTypes($conn){
    $query = "SELECT * FROM loan_type";
    $stmt = $conn->query($query);

    if($stmt == true){
        $loan_types = $stmt->fetchAll();
        return $loan_types;
    }else{
        return 0;
    }
}
//get loanType by id
function getLoanTypeById($loanType_id, $conn){
    $sql = "SELECT * FROM loan_type WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$loanType_id]);

    if($stmt->rowCount()==1){
        $loanType = $stmt->fetch();
        return $loanType;
    }else{
        return 0;
    }
}

//get loans 
function getAllLoans($conn){
    $query = "SELECT * FROM loan";
    $stmt = $conn->query($query);

    if($stmt == true){
        $loans = $stmt->fetchAll();
        return $loans;
    }else{
        return 0;
    }
}

//get loan by id
function getLoanById($loan_id, $conn){
    $sql = "SELECT * FROM loan WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$loan_id]);

    if($stmt->rowCount()==1){
        $loan = $stmt->fetch();
        return $loan;
    }else{
        return 0;
    }
}


//get employee by id
function getEmployeeById($employee_id, $role, $conn){
    $sql = "SELECT * FROM {$role} WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$employee_id]);

    if($stmt->rowCount()==1){
        $employee = $stmt->fetch();
        return $employee;
    }else{
        return 0;
    }
}

//get all payments
function getAllpayments($conn){
    $query = "SELECT * FROM payment";
    $stmt = $conn->query($query);

    if($stmt == true){
        $payment = $stmt->fetchAll();
        return $payment;
    }else{
        return 0;
    }
}


?>