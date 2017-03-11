<?php
require_once "../content/require.php";
session_destroy();
header("Location: ../index.php");