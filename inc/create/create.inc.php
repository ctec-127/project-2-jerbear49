<?php // Filename: connect.inc.php

require_once __DIR__ . "/../db/db_connect.inc.php";
require_once __DIR__ . "/../functions/functions.inc.php";
require_once __DIR__ . "/../app/config.inc.php";

$error_bucket = [];
$degree_program = null;
$financial_aid_yes = false;
$financial_aid_no = true;
$financial_aid = '';
$graduation_date = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // First insure that all required fields are filled in
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

    if (empty($_POST["student_id"])) {
        array_push($error_bucket, "<p>A student ID is required.</p>");
    } else {
        $student_id = intval($_POST["student_id"]);
    }

    $degree_program = $_POST["degree_program"];

    // $gpa = $_POST["gpa"];
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

    // Check to see if financial aid has been selected
    if (isset($_POST["financial_aid"])) {
        if ($_POST["financial_aid"] == 1) {
            // $financial_aid = $_POST["$financial_aid"];
            $financial_aid_yes = true;
            $financial_aid_no = false;
        } else if ($_POST["financial_aid"] == 0) {
            // $financial_aid = $_POST["$financial_aid"];
            $financial_aid_yes = false;
            $financial_aid_no = true;
        }
    }

    // Check to see if graduation date has been selected
    if (!empty($_POST["graduation_date"])) {
        $graduation_date = $_POST["graduation_date"];
    } else {
        $graduation_date = null;
    }

    // If we have no errors than we can try and insert the data
    if (count($error_bucket) == 0) {
        // Time for some SQL
        $sql = "INSERT INTO $db_table (first_name,last_name,email,phone,student_id,gpa,degree_program,financial_aid, graduation_date)";
        $sql .= "VALUES (:first_name,:last_name,:email,:phone,:student_id,:gpa,:degree_program,:financial_aid,:graduation_date)";

        $stmt = $db->prepare($sql);
        $stmt->execute(["first_name" => $first_name, "last_name" => $last_name, "student_id" => $student_id, "degree_program" => $degree_program, "gpa" => $gpa, "email" => $email, "phone" => $phone, "financial_aid" => $financial_aid, "graduation_date => $graduation_date"]);

        if ($stmt->rowCount() == 0) {
            echo '<div class="alert alert-danger" role="alert">
            I am sorry, but I could not save that record for you.</div>';
        } else {
            header("Location: display-records.php?message=The record for $first_name has been created.");
        }
    } else {
        display_error_bucket($error_bucket);
    }
}
