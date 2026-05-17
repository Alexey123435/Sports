<?
    require "../core.php";

    if(isset($_POST['avatarSend'])){
        $avatar = $_FILES['avatar'];

        if (!empty($_FILES["avatar"])) {    
        $files = $_FILES["avatar"];
        $fileType = mime_content_type($files["tmp_name"]); 

        $img = $files["name"];
        move_uploaded_file($files["tmp_name"], "../image/" . $img);    
            $newAvatar = $conn -> query("UPDATE `users` SET `avatar`='$img' WHERE `id` = '{$_SESSION['user']['id']}'");
            header('location:../Users/users.php');
        }
    }

    if(isset($_POST['sendBut'])){
        $title = $_POST['title'];
        $desc = $_POST['desc'];
        $img = $_FILES['image'];
        $date = date("Y-m-d");

        if (!empty($_FILES["image"])) {    
        $files = $_FILES["image"];
        $fileType = mime_content_type($files["tmp_name"]);

        if ($fileType !== "image/jpeg" && $fileType !== "image/png" && $fileType !== "image/svg" && $fileType !== "image/jpg")  
        {    
            $newItem = $conn -> query("INSERT INTO `posts`(`title`, `desc`, `img`, `userId`, `dateUpload`) VALUES ('$title','$desc','error.png','{$_SESSION['user']['id']}','$date')");
            $userStat = $conn -> query("SELECT * FROM `users` WHERE `id` = '{$_SESSION['user']['id']}'");
            foreach ($userStat as $key => $value) {
                $posts = $value['posts'];
                $posts++;
                $conn -> query("UPDATE `users` SET `posts`='$posts' WHERE `id` = '{$_SESSION['user']['id']}'");
            }
            header('location:../Users/users.php');
        }
        else
        {    
            $img = $files["name"];
            move_uploaded_file($files["tmp_name"], "../image/" . $img);    
            $newItem = $conn -> query("INSERT INTO `posts`(`title`, `desc`, `img`, `userId`, `dateUpload`) VALUES ('$title','$desc','$img','{$_SESSION['user']['id']}','$date')");
            $userStat = $conn -> query("SELECT * FROM `users` WHERE `id` = '{$_SESSION['user']['id']}'");
            foreach ($userStat as $key => $value) {
                $posts = $value['posts'];
                $posts++;
                $conn -> query("UPDATE `users` SET `posts`='$posts' WHERE `id` = '{$_SESSION['user']['id']}'");
            }
            header('location:../Users/users.php');
        }
        }
    }

    if(isset($_POST['delBut'])){
        $idPost = $_POST['deletePost'];
        $conn -> query("DELETE FROM `posts` WHERE `id` = '$idPost'");
        $userStat = $conn -> query("SELECT * FROM `users` WHERE `id` = '{$_SESSION['user']['id']}'");
            foreach ($userStat as $key => $value) {
                $posts = $value['posts'];
                $posts--;
                $conn -> query("UPDATE `users` SET `posts`='$posts' WHERE `id` = '{$_SESSION['user']['id']}'");
            }
    }

?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SportVibe</title>
    <link rel="stylesheet" href="users.css">
    <link rel="icon" href="iconka.jpg" type="image">
</head>
<body>
    <div class="wrapper">
        <header>
            <div class="head">
                <a href="../index.php"><p class="logo">SportVibe</p></a>
                <ul class="menu">
                    <li><a href="../index.php">Главная</a></li>
                    <li><a href="../UsersPost/userpost.php">Мои посты</a></li>
                    <li><a href="../Users/users.php">Мой профиль</a></li>
                    <li><a href="../logout.php">Выйти</a></li>
                </ul>
            </div>
        </header>
        <?
            $User = $conn -> query("SELECT * FROM `users` WHERE `id` = '{$_SESSION['user']['id']}'");
            foreach ($User as $key => $value) {
        ?>
        <div class="profile-container">
            <div class="profile-header">
                <div class="avatar">
                    <img src="../image/<?=$value['avatar']?>" alt="Картинка" class="profile-avatar">
                    <form action="" method="post" enctype="multipart/form-data">
                <label class="add-img btn-primary">Выбрать аватар<input type="file" accept="image/jpeg, image/svg, image/png, image/jpg" name="avatar" id="add-img"></label>
                        <button type="submit" class="add-img border btn-primary" name="avatarSend">Сохранить</button>
                    </form>
                </div>
                <div class="profile-info">
                    <h1><?=$_SESSION['user']['login']?></h1>
                    <p>Любитель спорта и здорового образа жизни</p>
                    <p>На сайте с: <?=$value['dateReg']?></p>
                    <div class="profile-stats">
                        <div class="stat">
                            <div class="stat-value"><?=$value['posts']?></div>
                            <div class="stat-label">Постов</div>
                        </div>
                        <div class="stat">
                            <div class="stat-value"><?=$value['comments']?></div>
                            <div class="stat-label">Комментариев</div>
                        </div>
                        <div class="stat">
                            <div class="stat-value"><?=$value['likes']?></div>
                            <div class="stat-label">Лайков</div>
                        </div>
                    </div>
                </div>
            </div>
            <?}?>
            <div class="create-post">
                <h2>Создать новый пост</h2>
                <form class="post-form" id="postForm" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="postTitle">Заголовок поста</label>
                        <input type="text" id="postTitle" class="form-input" placeholder="Введите заголовок" required name="title">
                    </div>

                    <!-- <div class="form-group">
                        <label for="postTitle">Категория статьи</label>
                        <input type="text" id="postTitle" class="form-input" placeholder="Введите категорию" required name="title">
                    </div> -->

                    <div class="form-group">
                        <label for="postContent">Содержание поста</label>
                        <textarea id="postContent" class="form-textarea" placeholder="Напишите содержание вашего поста..." required name="desc"></textarea>
                    </div>

                    <div class="form-group">
                        <label for="postImage">Изображение для поста</label>
                        <input type="file" id="postImage" class="form-input" accept="image/*" name="image" required>
                        <div class="image-preview" id="imagePreview" style="display: none;">
                            <img id="previewImage" src="#" alt="Предпросмотр">
                            <button type="button" id="removeImage" class="btn btn-remove">Удалить изображение</button>
                        </div>
                    </div>
                    <div class="form-actions">
                        <button type="reset" class="btn btn-secondary" id="clearForm">Очистить</button>
                        <button type="submit" class="btn btn-primary" name="sendBut">Опубликовать</button>
                    </div>
                </form>
            </div>
            <div class="create-post">
                <h2>Редактировать пост</h2>
                <form class="post-form" id="postForm" method="get" action="../Usersredd/Usersredd.php" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="postTitle">Выбрать пост</label>
                        <select name="selectPost" class="form-input">
                        <?
                            $allPostsSelect = $conn -> query("SELECT * FROM `posts` WHERE `userId` = '{$_SESSION['user']['id']}'");
                            foreach ($allPostsSelect as $key => $value) {
                        ?>
                            <option value="<?=$value['id']?>"><?=$value['id']?>: <?=$value['title']?></option>
                        <?}?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Перейти к изменению</button>
                </form>
            </div>
            <div class="create-post">
                <h2>Удалить пост</h2>
                <form class="post-form" id="postForm" method="post">
                    <div class="form-group">
                        <label for="postTitle">Выбрать пост</label>
                        <select name="deletePost" class="form-input">
                        <?
                            $allPostsSelect = $conn -> query("SELECT * FROM `posts` WHERE `userId` = '{$_SESSION['user']['id']}'");
                            foreach ($allPostsSelect as $key => $value) {
                        ?>
                            <option value="<?=$value['id']?>"><?=$value['id']?>: <?=$value['title']?></option>
                        <?}?>
                        </select>
                    </div>
                    <button type="submit" name="delBut" class="btn btn-primary">Удалить пост</button>
                </form>
            </div>
        </div>

        <footer>
            <div class="foot1">
                <p class="logo2">SportVibe</p>
            </div>
            <ul class="foot2">
                <li><a href="../index.php">Главная</a></li>
                <li><a href="../html/about.php">О нас</a></li>
            </ul>
            <div class="foot2">
                <li><a href="../html/contacts.php">Контакты</a></li>
                <li><a href="../pravila/pravila.php">Правила</a></li>
            </div>
            <div class="foot4">
                <a href="https://max.ru/join/VFYwYbx-fy_LxDezyTJ1A9DF0BAi0BVaBX1hwVVR-YM" target="_blank" rel="noopener"><img src="max.png" alt="Telegram"></a>
            </div>
        </footer>
       <script src="users.js"></script>
    </div>
</body>
</html>