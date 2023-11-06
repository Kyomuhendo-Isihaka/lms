<?php
//get all loantype
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

//get user by Id
function getUserById($user_id, $conn){
    $sql = "SELECT * FROM user WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$user_id]);

    if($stmt->rowCount()==1){
        $user = $stmt->fetch();
        return $user;
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

//get payments
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