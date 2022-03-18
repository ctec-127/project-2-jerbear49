<?php // Filename: update.inc.php

require_once __DIR__ . "/../db/db_connect.inc.php";
require_once __DIR__ . "/../app/config.inc.php";

$error_bucket = [];
// $degree_program = null;
$financial_aid_yes = '';
$financial_aid_no = '';
$financial_aid = '';

if (isset($_GET["id"])) {
    $id = $_GET["id"];
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];
    // First insure that all required fields are filled in
    if (empty($_POST["student_id"])) {
        array_push($error_bucket, "<p>A student ID is required.</p>");
    } else {
        $student_id = intval($_POST["student_id"]);
    }

    if (empty($_POST["first_name"])) {
        array_push($error_bucket, "<p>A first name is required.</p>");
    } else {
        $first_name = $_POST["first_name"];
    }

    if (empty($_POST["last_name"])) {
        array_push($error_bucket, "<p>A last name is required.</p>");
    } else {
        $last_name = $_POST["last_name"];
    }

    $degree_program = $_POST["degree_program"];

    if (empty($_POST["gpa"])) {
        $gpa = 0;
    } else {
        $gpa = floatval($_POST["gpa"]);
    }

    if (empty($_POST["email"])) {
        array_push($error_bucket, "<p>An email address is required.</p>");
    } else {
        $email = $_POST["email"];
    }

    if (empty($_POST["phone"])) {
        array_push($error_bucket, "<p>A phone number is required.</p>");
    } else {
        $phone = $_POST["phone"];
    }

    if (isset($_POST["financial_aid"])) {
        if ($_POST["financial_aid"] == 1) {
            $financial_aid = $_POST["financial_aid"];
            $financial_aid_yes = true;
            $financial_aid_no = false;
        } else {
            $financial_aid = $_POST["financial_aid"];
            $financial_aid_yes = false;
            $financial_aid_no = true;
        }
    } elseif (isset($_POST["financial_aid"])) {
        array_push($error_bucket, '<p>Please select a financial aid option.</p>');
    }

    // Check to see if graduation date has been selected
    if (isset($_POST["graduation_date"])) {
        $graduation_date = $_POST["graduation_date"];
    } else {
        $graduation_date = null;
    }

    if (count($error_bucket) == 0) {
        // Time for some SQL
        $sql = "UPDATE $db_table SET student_id=:student_id, first_name=:first_name, last_name=:last_name, degree_program=:degree_program, gpa=:gpa, email=:email, phone=:phone, financial_aid=:financial_aid, graduation_date=:graduation_date WHERE id=:id";
        $stmt = $db->prepare($sql);
        $stmt->execute(["first_name" => $first_name, "last_name" => $last_name, "student_id" => $student_id, "degree_program" => $degree_program, "gpa" => $gpa, "email" => $email, "phone" => $phone, "financial_aid" => $financial_aid, "id" => $id, "graduation_date" => $graduation_date]);
        // $sql = "INSERT INTO $db_table (first_name,last_name,email,phone,student_id,gpa,degree_program,financial_aid) ";
        // $sql .= "VALUES (:first,:last,:email,:phone,:student_id,:gpa,:degree_program,:financial_aid)";

        if ($stmt->rowCount() != 1 and $stmt->rowCount() != 0) {
            echo '<div class="alert alert-danger" role="alert">
            I am sorry, but I could not update that record for you.</div>';
        } else {
            header("Location: display-records.php?message=The record for $first_name has been updated.");
        }
    } else {
        display_error_bucket($error_bucket);
    }
}

$sql = "SELECT * FROM $db_table WHERE id=:id LIMIT 1";

$stmt = $db->prepare($sql);
$stmt->execute(["id" => $id]);

if ($stmt->rowCount() == 1) {
    $row = $stmt->fetch();
    $student_id = $row->student_id;
    $first_name = $row->first_name;
    $last_name = $row->last_name;
    $degree_program = $row->degree_program;
    $gpa = $row->gpa;
    $email = $row->email;
    $phone = $row->phone;
    $financial_aid = $row->financial_aid;
    $graduation_date = $row->graduation_date;
    // Check to see if financial aid has been selected
    if ($financial_aid == 1) {
        $financial_aid_yes = true;
        $financial_aid_no = false;
    } else if ($financial_aid == 0) {
        $financial_aid_yes = false;
        $financial_aid_no = true;
    }
}
