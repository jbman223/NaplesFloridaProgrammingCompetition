<?php
require_once "db.php";
session_start();

function isLoggedIn () {
    return isset($_SESSION['team_id']);
}

function isAdmin() {
    global $db;
    $state = $db->prepare("SELECT * FROM teams WHERE id = ?");
    $state->execute(array($_SESSION['team_id']));
    return $state->fetchAll()[0]['admin'] == 1;
}

function teamName($id) {
    global $db;
    $state = $db->prepare("SELECT * FROM teams WHERE id = ?");
    $state->execute(array($id));
    return $state->fetchAll()[0]['team_name'];
}