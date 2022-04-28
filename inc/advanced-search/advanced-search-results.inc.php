<?php
// if ($_SERVER["REQUEST_METHOD"] == "POST") {
//     echo '<h2>Results will go here</h2>';
// } else {
//     echo '<div class="alert alert-info">';
//     echo '<h2>Search results will appear here</h2>';
//     echo '</div>';
// }

// Code to process form data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    echo "<h2>Search Results</h2>";

    $sql = "SELECT * FROM student_v2 WHERE ";
    $data = [];
    if (!empty($_POST["first_name"])) {
        array_push($data, "first_name LIKE {$db->quote($_POST["first_name"] . '%')}");
    }

    if (!empty($_POST["last_name"])) {
        array_push($data, "last_name LIKE {$db->quote($_POST["last_name"] . '%')}");
    }

    if (!empty($_POST["student_id"])) {
        array_push($data, "student_id = {$_POST["student_id"]}");
    }

    if (!empty($_POST["gpa"])) {
        array_push($data, "gpa = {$_POST["gpa"]}");
    }

    if (!empty($_POST["email"])) {
        array_push($data, "email LIKE {$db->quote($_POST["email"] . '%')}");
    }

    if (!empty($_POST["phone"])) {
        array_push($data, "phone LIKE {$db_quote($_POST["phone"])}");
    }

    if (!empty($_POST["graduation_date"])) {
        array_push($data, "graduation_date = {$_POST["graduation_date"]}");
    }

    array_push($data, "financial_aid = {$_POST["financial_aid"]}");
    array_push($data, "degree_program = {$db->quote($_POST["degree_program"])}");

    $sql = $sql . implode(" AND ", $data);

    $stmt = $db->prepare($sql);
    $stmt->execute();
    $results = $stmt->fetchAll();
    display_record_table($results);
} else {
    echo '<div class="alert alert-info">';
    echo '<h2>Search results will appear here</h2>';
    echo '</div>';
}
