<?php // Filename: advanced-search.inc.php

require_once __DIR__ . "/../db/db_connect.inc.php";
require_once __DIR__ . "/../app/config.inc.php";


$degree_program = null;
$financial_aid_yes = false;
$financial_aid_no = true;
$financial_aid = '';
$graduation_date = '';
