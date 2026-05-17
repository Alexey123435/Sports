<?
    require "../core.php";

    $id = $_GET['selectPost'];
    
    if(isset($_POST['EditPost'])){
        $title = $_POST['title'];
        $desc = $_POST['desc'];
        $category = $_POST['category'];
        $img = $_FILES['image'];
        
        if (!empty($_FILES["image"])) {
            $files = $_FILES["image"];
            $fileType = mime_content_type($files["tmp_name"]); 
            

            if ($fileType !== "image/jpeg" && $fileType !== "image/png" && $fileType !== "image/svg" && $fileType !== "image/jpg")  
                {
                    $newItem = $conn -> query("UPDATE `posts` SET `title`='$title',`desc`='$desc',`category`='$category',`img`='error.png' WHERE `id` = '$id'");
                    if($_SESSION['user']['role'] == 1){
                        header('location:../Users/users.php');
                    }else{
                        header('location:../Admin/admin.php');
                    }
                }
                else
                    {    
                        $img = $files["name"];
                        move_uploaded_file($files["tmp_name"], "../image/" . $img);
                        $newItem = $conn -> query("UPDATE `posts` SET `title`='$title',`desc`='$desc',`category`='$category',`img`='$img' WHERE `id` = '$id'");
                        if($_SESSION['user']['role'] == 1){
                            header('location:../Users/users.php');
                        }else{
                            header('location:../Admin/admin.php');
                        }                       
        
                    }
                }
    }

?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SportVibe</title>
    <link rel="stylesheet" href="Usersredd.css">
    <link rel="icon" href="iconka.jpg" type="image">
</head>
<body>
    <div class="wrapper">
        <header>
            <div class="head">
                <a href="../index.php"><p class="logo">SportVibe</p></a>
                <ul class="menu">
                    <li><a href="../index.php">Главная</a></li>
                    <?if($_SESSION['user']['role'] == 1){?>
                    <li><a href="../Users/users.php">Вернуться в профиль</a></li>
                    <?}else{?>
                    <li><a href="../Admin/admin.php">Вернуться в Админ-панель</a></li>
                    <?}?>
                    <li><a href="../index.php">Выйти</a></li>
                </ul>
            </div>
        </header>

        <div class="profile-container">
            <!-- <div class="profile-header">
                <img src="avatar.jpg" alt="Картинка" class="profile-avatar">
                <div class="profile-info">
                    <h1>Пользователь</h1>
                    <p>Любитель спорта и здорового образа жизни</p>
                    <p>На сайте с: 15 ноября 2025</p>
                    <div class="profile-stats">
                        <div class="stat">
                            <div class="stat-value">7</div>
                            <div class="stat-label">Постов</div>
                        </div>
                        <div class="stat">
                            <div class="stat-value">7</div>
                            <div class="stat-label">Комментариев</div>
                        </div>
                        <div class="stat">
                            <div class="stat-value">7</div>
                            <div class="stat-label">Лайков</div>
                        </div>
                    </div>
                </div>
            </div> -->

            <div class="create-post">
                <?
                    $thisPostEdit = $conn -> query("SELECT * FROM `posts` WHERE `id` = '$id'");
                    foreach ($thisPostEdit as $key => $value) {
                ?>
                <h2>Редактирование поста</h2>
                <form class="post-form" id="postForm" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="postTitle">Заголовок поста</label>
                        <input name="title" type="text" id="postTitle" class="form-input" placeholder="Введите заголовок" required value="<?=htmlspecialchars($value['title'])?>">
                    </div>

                    <div class="form-group">
                        <label for="post-title">Категория статьи</label>
                        <select name="category" id="" class="form-input">
                            <option value="Хоккей">Хоккей</option>
                            <option value="Биатлон">Биатлон</option>
                            <option value="Волейбол">Волейбол</option>
                            <option value="Футбол">Футбол</option>
                            <option value="Баскетбол">Баскетбол</option>
                            <option value="Другое">Другое</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="postContent">Содержание поста</label>
                        <textarea name="desc" id="postContent" class="form-textarea" placeholder="Напишите содержание вашего поста..." required><?=htmlspecialchars($value['desc'])?></textarea>
                    </div>

                    <div class="form-group">
                        <label for="postImage">Изображение для поста (опционально)</label>
                        <input type="file" id="postImage" class="form-input" accept="image/*" name="image" value="<?=htmlspecialchars($value['img'])?>">
                        <div class="image-preview" id="imagePreview" style="display: none;" >
                            <img id="previewImage" src="#" alt="Предпросмотр">
                            <button type="button" id="removeImage" class="btn btn-remove">Удалить изображение</button>
                        </div>
                    </div>
                    <div class="form-actions">
                        <button type="reset" class="btn btn-secondary" id="clearForm">Очистить</button>
                        <button type="submit" class="btn btn-primary" name="EditPost">Обновить пост</button>
                    </div>
                </form>
                <?}?>
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
       <!-- <script src="users.js"></script> -->
    </div>
</body>
</html>