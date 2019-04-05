<?php
require_once "require.php";
session_destroy();
header("Location: ../index.php");