<?php
session_start();

if(!empty($_SESSION['supra_csv'])) {
    extract($_SESSION['supra_csv']);
    header("Pragma: public");
    header("Expires: 0");
    header("Cache-Control: private");
    header("Content-type: text/csv");
    header("Content-Disposition: attachment; filename=$filename");
    header("Accept-Ranges: bytes");
    echo $content;
}
