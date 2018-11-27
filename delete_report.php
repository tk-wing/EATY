<?php
 
    require_once('dbconnect.php');
 
    $report_each = $_GET["report_each"];
 
    $sql ="DELETE FROM `reports` WHERE `id` = ?";
 
    $data = array($report_each);
 
    $stmt = $dbh->prepare($sql);
    $stmt->execute($data);
 
    header("Location: report.php");
    exit();
