<?php
/**
 * If you use a password to your local mysql-setup, store it somewhere else and secure.
 * This requires you to have an local mysql-db called improved_localhost created
 */
if ($_POST['action'] == 'delete_todo') {
    $db = mysqli_connect('localhost', '>>insert username here<<', '>>insert password here<<', 'styled_localhost');
    if (!$db) {
        throw new Exception("Error Processing Request", 1);
    }
    $sql = "UPDATE todos SET deleted = 1 WHERE id ="  . $_POST['todo_id'];
    $res = $db->query($sql);
    mysqli_close($db);
}

if ($_POST['action'] == 'update_done') {
    $db = mysqli_connect('localhost', '>>insert username here<<', '>>insert password here<<', 'styled_localhost');
    if (!$db) {
        throw new Exception("Error Processing Request", 1);
    }
    $sql = "UPDATE todos SET done = '" . $_POST['done'] . "' WHERE id = '"  . $_POST['todo_id'] . "'";
    $res = $db->query($sql);
    mysqli_close($db);
}

if ($_POST['action'] == 'add_todo') {
    $db = mysqli_connect('localhost', '>>insert username here<<', '>>insert password here<<', 'styled_localhost');
    if (!$db) {
        throw new Exception("Error Processing Request", 1);
    }
    $sql = "INSERT INTO todos (todo, done, deleted) VALUES('".$_POST['todo']."', 0, 0)";
    $res = $db->query($sql);
    mysqli_close($db);
}
