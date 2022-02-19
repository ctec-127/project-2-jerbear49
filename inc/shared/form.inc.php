<?php // Filename: form.inc.php 
?>

<!-- Note the use of sticky fields below -->
<!-- Note the use of the PHP Ternary operator
Scroll down the page
http://php.net/manual/en/language.operators.comparison.php#language.operators.comparison.ternary
-->

<?php
// Button label logic
if (basename($_SERVER['PHP_SELF']) == 'create-record.php') {
    $button_label = "Save New Record";
} else if (basename($_SERVER['PHP_SELF']) == 'update-record.php') {
    $button_label = "Save Updated Record";
} else if (basename($_SERVER['PHP_SELF']) == 'advanced-search.php') {
    $button_label = "Search...";
}
?>

<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
    <label class="col-form-label" for="first">First Name</label>
    <input class="form-control" type="text" id="first" name="first" value="<?= isset($first) ? $first : null ?>">
    <br>
    <label class="col-form-label" for="last">Last Name</label>
    <input class="form-control" type="text" id="last" name="last" value="<?= isset($last) ? $last : null ?>">
    <br>
    <label class="col-form-label" for="id">Student ID</label>
    <input class="form-control" type="number" id="id" name="student_id" value="<?= isset($student_id) ? $student_id : null ?>">
    <br>
    <!-- Sticky select for degree_program -->
    <label class="col-form-label" for="degreeprogram">Degree Program</label>
    <select class="form-select" aria-label="Default select " id="degreeprogram" name="degree_program">
        <option value="Undeclared" selected <?= $degree_program == "Undeclared" ? "selected" : null ?>>Undeclared</option>
        <option value="AAT Web Development" <?= $degree_program == "AAT Web Development" ? "selected" : null ?>>AAT Web Development</option>
        <option value="AAS Business Administration" <?= $degree_program == "AAS Business Administration" ? "selected" : null ?>>AAS Business Administration</option>
        <option value="AAT Digital Media Arts" <?= $degree_program == "AAS Digital Media Arts" ? "selected" : null ?>>AAT Digital Media Arts</option>
        <option value="BAS Dental Hygiene" <?= $degree_program == "BAS Dental Hygiene" ? "selected" : null ?>>BAS Dental Hygiene</option>
        <option value="BAS Human Services" <?= $degree_program == "BAS Human Services" ? "selected" : null ?>>BAS Human Services</option>
    </select>
    <br>
    <label class="col-form-label" for="gpa">GPA</label>
    <input class="form-control" type="number" id="gpa" name="gpa" min="0" max="4" step="0.01" value="<?= isset($gpa) ? $gpa : null ?>">
    <br>
    <!-- Sticky radio -->
    <!-- Use of the ternary makes ti 'sticky' if 'isset' -->
    <h6>Financial Aid</h6>
    <div class="form-check">
        <input class="form-check-input" type="radio" value="1" id="finaid_yes" name="financial_aid" <?= isset($financial_aid_yes) ? 'checked' : null ?>>
        <label class="form-check-label" for="finaid_yes">Yes</label>
    </div>
    <div class="form-check">
        <input class="form-check-input" type="radio" value="0" id="finaid_no" name="financial_aid" <?= isset($financial_aid__no) ? 'checked' : null ?>>
        <label class="form-check-label" for="finaid_no">No</label>
    </div>
    <br>
    <label class="col-form-label" for="email">Email</label>
    <input class="form-control" type="text" id="email" name="email" value="<?= isset($email) ? $email : null ?>">
    <br>
    <label class="col-form-label" for="phone">Phone</label>
    <input class="form-control" type="text" id="phone" name="phone" value="<?= isset($phone) ? $phone : null ?>">
    <br>
    <br>
    <a href="display-records.php">Cancel</a>&nbsp;&nbsp;
    <button class="btn btn-primary" type="submit"><?= $button_label ?></button>
</form>