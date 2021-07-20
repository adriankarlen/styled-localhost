<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Localhost</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../index-custom-style.css">
</head>

<body>

    <div class="wrapper">
        <div class="projekte">
            <a href="http://localhost/personal/" class="projekte-link active">
                <i class="fas fa-laptop-house image-navbar"></i>
                <span class="tooltiptext">side projects</span>
            </a>
            <a href="http://localhost/workspace/" class="projekte-link">
                <i class="fas fa-briefcase image-navbar"></i>
                <span class="tooltiptext">workspace</span>
            </a>
            <hr />
            <a href="https://gitlab.arksysweb.com" class="projekte-link">
                <i class="fab fa-gitlab image-navbar"></i>
                <span class="tooltiptext">gitlab</span>
            </a>
            <a href="https://github.com/" class="projekte-link">
                <i class="fab fa-github image-navbar"></i>
                <span class="tooltiptext">github</span>
            </a>
            <a href="https://drinordic.atlassian.net/secure/RapidBoard.jspa?rapidView=1597" class="projekte-link">
                <i class="fab fa-jira image-navbar"></i>
                <span class="tooltiptext">jira</span>
            </a>
            <a href="https://drinordic.atlassian.net/wiki/discover/all-updates" class="projekte-link">
                <i class="fab fa-confluence image-navbar"></i>
                <span class="tooltiptext">confluence</span>
            </a>
            <a href="https://secret.exsitec.se/" class="projekte-link">
                <i class="fas fa-user-secret image-navbar"></i>
                <span class="tooltiptext">secret server</span>
            </a>
            <a href="https://qlik.exsitec.se/" class="projekte-link">
                <i class="fas fa-brain image-navbar"></i>
                <span class="tooltiptext">qlik</span>
            </a>
            <a href="http://localhost/phpMyAdmin/" class="projekte-link">
                <i class="fas fa-database image-navbar"></i>
                <span class="tooltiptext">phpMyAdmin</span>
            </a>
            <a href="http://localhost/info.php/" class="projekte-link">
                <i class="fab fa-php image-navbar"></i>
                <span class="tooltiptext">php info</span>
            </a>
        </div>
        <div class="wrapper-inner">
            <h2 class="title">side projects</h2>
            <ul class="list">

                <?php

                function scan_dir($dir_lm)
                {
                    $ignored = array('.', '..', '.svn', '.htaccess', '.DS_Store');

                    $files = array();
                    foreach (scandir($dir_lm) as $file) {
                        if (in_array($file, $ignored)) continue;
                        $files[$file] = filemtime($dir_lm . '/' . $file);
                    }
                    arsort($files);
                    $files = array_keys($files);

                    return ($files) ? $files : false;
                }

                $dir = scan_dir(getcwd());

                ?>

                <?php foreach ($dir as $file) : ?>

                    <?php if ($file != "." && $file != ".." && $file != "index.php") : ?>

                        <li class="list-item">
                            <a class="link" href="<?php echo $file; ?>"><?php echo $file; ?></a>
                            <a class="link-btn" href="http://<?php echo $file; ?>.test.arksysweb.com"><em>v</em>Host</a>
                        </li>

                    <?php endif; ?>

                <?php endforeach; ?>

            </ul>
        </div>
        <div id="todos" class="todos">
            <h2 class="title">todos</h2>
            <div class="todos-inner">
                <ul id='todos-items' class="todos-items">
                    <?php
                    function query($sql)
                    {
                        $db = mysqli_connect('localhost', 'root', 'knackapå', 'improved_localhost');
                        if (!$db) {
                            echo "Error: Unable to connect to MySQL." . PHP_EOL;
                            echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
                            echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
                            exit;
                        }
                        $res = $db->query($sql);
                        mysqli_close($db);
                        return $res;
                    }

                    $sql = "SELECT * FROM todos WHERE deleted = 0 ORDER BY id ASC";
                    $todos = query($sql);
                    ?>

                    <?php while ($todo = $todos->fetch_assoc()) : ?>
                        <form class='todo-grid'>
                            <label class='container'> <?php echo $todo['todo']; ?>
                                <?php $checked = $todo['done'] == 1 ? 'checked' : ''; ?>
                                <input id=<?php echo $todo['id'] ?> class="checkbox" name="checkbox" type="checkbox" onChange="checkClicked(this)" <?php echo $checked ?>>
                                <span class="checkmark"></span>
                            </label>
                            <span class="close" name=<?php echo 'close' . $todo['id'] ?> title="delete todo" onClick="deleteTodo(<?php echo $todo['id'] ?>); return false">×</span>
                        </form>
                    <?php endwhile; ?>
                </ul>
                <form id='add-todo' class='todo-submit-grid' autocomplete="off">
                    <input type='text' id='todo-input' name='todo-input'>
                    <input type='submit' id='todo-submit' value='add to list' onClick="addTodo()">
                </form>
            </div>
        </div>
    </div>

</body>
<script type="text/javascript">
    function deleteTodo(id) {
        $.ajax({
            type: "POST",
            url: '../ajax.php',
            data: {
                action: 'delete_todo',
                todo_id: id
            },
            success: function(html) {}
        });
        $("#todos-items").load(" #todos-items > *");
    }

    function checkClicked(cb) {
        $.ajax({
            type: "POST",
            url: '../ajax.php',
            data: {
                action: 'update_done',
                todo_id: parseInt(cb.id),
                done: cb.checked ? 1 : 0
            },
            success: function(html) {},
        });
    }

    function addTodo() {
        let todo = $('#add-todo').serializeArray()[0].value
        if (todo) {
            $.ajax({
                type: "POST",
                url: '../ajax.php',
                data: {
                    action: 'add_todo',
                    todo: todo
                },
                success: function(html) {},
            });
            $("#todos-items").load(" #todos-items > *");
        }
    }
</script>

</html>