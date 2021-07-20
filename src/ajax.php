<?php
if ($_POST['action'] == 'delete_todo') {
    $db = mysqli_connect('localhost', 'username', 'knackapå', 'improved_localhost');
    if (!$db) {
        throw new Exception("Error Processing Request", 1);
    }
    $sql = "UPDATE todos SET deleted = 1 WHERE id ="  . $_POST['todo_id'];
    $res = $db->query($sql);
    mysqli_close($db);
}

if ($_POST['action'] == 'update_done') {
    $db = mysqli_connect('localhost', 'username', 'knackapå', 'improved_localhost');
    if (!$db) {
        throw new Exception("Error Processing Request", 1);
    }
    $sql = "UPDATE todos SET done = '" . $_POST['done'] . "' WHERE id = '"  . $_POST['todo_id'] . "'";
    $res = $db->query($sql);
    mysqli_close($db);
}

if ($_POST['action'] == 'add_todo') {
    $db = mysqli_connect('localhost', 'username', 'knackapå', 'improved_localhost');
    if (!$db) {
        throw new Exception("Error Processing Request", 1);
    }
    $sql = "INSERT INTO todos (todo, done, deleted) VALUES('".$_POST['todo']."', 0, 0)";
    $res = $db->query($sql);
    mysqli_close($db);
}
