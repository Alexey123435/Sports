<?
    require "../core.php";

    if(!isset($_SESSION['user']) || $_SESSION['user']['role'] != 2) {
        header("Location: ../index.php");
        exit();
    }

    if(isset($_POST['sendBut'])){
        $title = $_POST['title'];
        $category = $_POST['category'];
        $desc = $_POST['desc'];
        $img = $_FILES['image'];
        $date = date("Y-m-d");

        if (!empty($_FILES["image"])) {    
        $files = $_FILES["image"];
        $fileType = mime_content_type($files["tmp_name"]); 
        $img = $files["name"];
        move_uploaded_file($files["tmp_name"], "../image/" . $img);    
        // $newItem = $conn -> query("INSERT INTO `posts`(`title`, `desc`, `category`, `img`, `userId`, `dateUpload`) VALUES ('$title','$desc', '$category', '$img','{$_SESSION['user']['id']}','$date')");
        $newItem = $conn -> query("INSERT INTO `posts`(`title`, `desc`, `category`, `img`, `userId`, `dateUpload`) VALUES ('$title','$desc','$category','$img','{$_SESSION['user']['id']}','$date')");

        $userStat = $conn -> query("SELECT * FROM `users` WHERE `id` = '{$_SESSION['user']['id']}'");
        foreach ($userStat as $key => $value) {
            $posts = $value['posts'];
            $posts++;
            $conn -> query("UPDATE `users` SET `posts`='$posts' WHERE `id` = '{$_SESSION['user']['id']}'");
        }
        header('location:../Admin/admin.php');
        }
    }

    if(isset($_POST['delBut'])){
        $idPost = $_POST['deletePost'];
        $conn -> query("DELETE FROM `posts` WHERE `id` = '$idPost'");
    }

    if(isset($_POST['delSelectedPost'])){
        $idPost = $_POST['deletePost'];
        $conn -> query("DELETE FROM `posts` WHERE `id` = '$idPost'");
    }

    if(isset($_POST['delCom'])){
        $idCom = $_POST['delSelectedCom'];
        $conn -> query("DELETE FROM `comments` WHERE `id` = '$idCom'");
    }
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SportVibe</title>
    <link rel="icon" href="iconka.jpg" type="image">
    <link rel="stylesheet" href="admin.css">
    <link rel="stylesheet" href="../Ostate/Ostate.css">
</head>
<body>
    <header>
        <div class="head">
            <a href="../index.php"><p class="logo">SportVibe</p></a>
            <ul class="menu">
                <li><a href="../index.php">Главная</a></li>
                <li><a href="../Admin/admin.php">Администрирование</a></li>
                <li><a href="../logout.php">Выйти</a></li>
            </ul>
        </div>
    </header>
    <?
            $User = $conn -> query("SELECT * FROM `users` WHERE `id` = '{$_SESSION['user']['id']}'");
            foreach ($User as $key => $value) {
    ?>
    <div class="admin-container">
        <aside class="admin-sidebar">
            <div class="admin-logo">
                <h2>Панель Администратора</h2>
            </div>
            <nav class="admin-nav">
                <ul>
                    <li><a href="#" class="active"><i>📊</i>Дашборд</a></li>
                    <li><a href="#articles"><i>📝</i> Статьи</a></li>
                    <li><a href="#comments"><i>💬</i> Комментарии</a></li>
                    <li><a href=#add-article"><i>➕</i> Добавить пост</a></li>
                    <li><a href="#edit-post"><i>✏️</i> Редактировать пост</a></li>
                    <li><a href="#delete-post"><i>🗑️</i> Удалить пост</a></li>
                    <li><a href="../index.php"><i>🏠</i> На сайт</a></li>
                </ul>
            </nav>
        </aside>
        <main class="admin-content">
            <header class="admin-header">
                <h1>Управление Администратора</h1>
                <div class="user-info">
                    <div class="user-avatar">
                        <img src="1.jpg" alt="Картинка" id="admin-avatar-img">
                    </div>
                    <div>
                        <div><?=$_SESSION['user']['login']?></div>
                        <div style="font-size: 0.8rem; color: #aaa;"><?=$_SESSION['user']['email']?></div>
                    </div>
                </div>
            </header>
            <div class="stats-cards">
                <div class="stat-card">
                    <div class="stat-icon">📝</div>
                    <div class="stat-info">
                        <h3>24</h3>
                        <p>Статьи</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">💬</div>
                    <div class="stat-info">
                        <h3>156</h3>
                        <p>Комментарии</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">👥</div>
                    <div class="stat-info">
                        <h3>342</h3>
                        <p>Пользователи</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">👁️</div>
                    <div class="stat-info">
                        <h3>5.2K</h3>
                        <p>Просмотры</p>
                    </div>
                </div>
            </div>
            <section class="admin-section">
                <div class="section-header">
                    <h2>Последние статьи</h2>
                    <!-- <button class="btn btn-primary">Добавить статью</button> -->
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>Заголовок</th>
                            <th>Автор</th>
                            <th>Дата</th>
                            <th>Статус</th>
                            <th>Действия</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?
                            $allPosts = $conn -> query("SELECT `posts`.*, `users`.*, `posts`.`id` AS 'PostId'
                  FROM `posts` 
	            LEFT JOIN `users` ON `posts`.`userId` = `users`.`id`");

                            foreach ($allPosts as $key => $value) {
                        ?>
                        <tr>
                            <form method="post">
                            <input type="hidden" name="deletePost" value="<?=$value['PostId']?>">
                            <td><?=$value['title']?></td>
                            <td><?=$value['email']?></td>
                            <td><?=$value['dateUpload']?></td>
                            <td><span class="status status-published">Опубликовано</span></td>
                            <td>
                                <div class="action-buttons">
                                    <!-- <button class="action-btn edit-btn">Редактировать</button> -->
                                    <button name="delSelectedPost" type="submit" class="action-btn delete-btn">Удалить</button>
                                </div>
                            </form>
                            </td>
                        </tr>
                        <?}?>
                        <!-- <tr>
                            <td>Воллейбол, ВК ОМИЧКА снова самая лучшая?</td>
                            <td>Администратор</td>
                            <td>26.11.2025</td>
                            <td><span class="status status-published">Опубликовано</span></td>
                            <td>
                                <div class="action-buttons">
                                    <button class="action-btn edit-btn">Редактировать</button>
                                    <button class="action-btn delete-btn">Удалить</button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Биатлон 2025/2026 – открытие нового сезона</td>
                            <td>Администратор</td>
                            <td>27.11.2025</td>
                            <td><span class="status status-published">Опубликовано</span></td>
                            <td>
                                <div class="action-buttons">
                                    <button class="action-btn edit-btn">Редактировать</button>
                                    <button class="action-btn delete-btn">Удалить</button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Значение и роль спорта в жизни человека</td>
                            <td>Пользователь</td>
                            <td>28.11.2025</td>
                            <td><span class="status status-draft">На проверке</span></td>
                            <td>
                                <div class="action-buttons">
                                    <button class="action-btn edit-btn">Редактировать</button>
                                    <button class="action-btn delete-btn">Удалить</button>
                                </div>
                            </td>
                        </tr> -->
                    </tbody>
                </table>
            </section>
            <section class="admin-section">
                <div class="section-header">
                    <h2>Последние комментарии</h2>
                    <!-- <button class="btn btn-primary">Все комментарии</button> -->
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>Пользователь</th>
                            <th>Комментарий</th>
                            <th>Статья</th>
                            <th>Дата</th>
                            <th>Действия</th>
                        </tr>
                    </thead>
                    <tbody> 
                        <?
                            $allcomm = $conn -> query("SELECT `comments`.*, `posts`.*, `users`.*, `comments`.`id` AS 'CommentsId'
FROM `comments` 
	LEFT JOIN `posts` ON `comments`.`postId` = `posts`.`id` 
	LEFT JOIN `users` ON `comments`.`userId` = `users`.`id`;");

                            foreach ($allcomm as $key => $value) {
                        ?>
                        <tr>
                            <form method="post">
                            <input type="hidden" name="delSelectedCom" value="<?=$value['CommentsId']?>">
                            <td><?=$value['login']?></td>
                            <td><?=$value['text']?></td>
                            <td><?=$value['title']?></td>
                            <td><?=$value['dateUpload']?></td>
                            <td>
                                <div class="action-buttons">
                                    <!-- <button class="action-btn edit-btn">Редактировать</button> -->
                                    <button name="delCom" type="submit" class="action-btn delete-btn">Удалить</button>
                                </div></form>
                            </td>
                        </tr>
                        <?}?>
                    </tbody>
                </table>
            </section>
            <section class="admin-section">
                <div class="section-header">
                    <h2>Добавить новую статью</h2>
                </div>
                <form method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="post-title">Заголовок статьи</label>
                        <input type="text" id="post-title" class="form-control" placeholder="Введите заголовок" name="title">
                    </div>

                    <div class="form-group">
                        <label for="post-title">Категория статьи</label>
                        <select name="category" id="" class="form-control">
                            <option value="Хоккей">Хоккей</option>
                            <option value="Биатлон">Биатлон</option>
                            <option value="Волейбол">Волейбол</option>
                            <option value="Футбол">Футбол</option>
                            <option value="Баскетбол">Баскетбол</option>
                            <option value="Другое">Другое</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="post-content">Содержание статьи</label>
                        <textarea id="post-content" class="form-control" placeholder="Введите текст статьи" name="desc"></textarea>
                    </div>
                    
                    <div class="form-row">
                        <!-- <div class="form-group">
                            <label for="post-author">Автор</label>
                            <input type="text" id="post-author" class="form-control" value="Администратор">
                        </div> -->
                        
                        <!-- <div class="form-group">
                            <label for="post-category">Категория</label>
                            <select id="post-category" class="form-control">
                                <option>Общая</option>
                                <option>Хоккей</option>
                                <option>Волейбол</option>
                                <option>Биатлон</option>
                            </select>
                        </div> -->
                    </div>
                    
                    <div class="form-group">
                        <label for="post-image">Изображение статьи</label>
                        <input type="file" id="post-image" class="form-control-file" accept="image/*" name="image" required>
                    </div>
                    <button type="submit" class="btn btn-success" name="sendBut">Опубликовать статью</button>
                </form>
            </section>
            <div class="admin-section">
                <div class="section-header">
                    <h2>Редактировать пост</h2>
                </div>
            <form class="post-form" id="postForm" method="get" action="../Usersredd/Usersredd.php" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="postTitle">Выбрать пост</label>
                    <select name="selectPost" class="form-control">
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
        <div class="admin-section">
                <div class="section-header">
                    <h2>Удалить пост</h2>
                </div>
            <form class="post-form" id="postForm" method="post">
                <div class="form-group">
                    <label for="postTitle">Выбрать пост</label>
                    <select name="deletePost" class="form-control">
                    <?
                        $allPostsSelect = $conn -> query("SELECT * FROM `posts` ");
                        foreach ($allPostsSelect as $key => $value) {
                    ?>
                        <option value="<?=$value['id']?>"><?=$value['id']?>: <?=$value['title']?></option>
                    <?}?>
                    </select>
                </div>
                <button type="submit" name="delBut" class="btn btn-primary">Удалить пост</button>
            </form>
        </div>
        </main>
    </div>
    <?}?>
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
            <a href="https://maxln.ru/8nucVX" target="_blank" rel="noopener"><img src="max.png" alt=""></a>
        </div>
    </footer>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Обработка кликов по кнопкам удаления
            const deleteButtons = document.querySelectorAll('.delete-btn');
            deleteButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const row = this.closest('tr');
                    if (confirm('Вы уверены, что хотите удалить этот элемент?')) {
                        row.style.opacity = '0';
                        setTimeout(() => {
                            row.remove();
                        }, 300);
                    }
                });
            });
            
            // Обработка кликов по кнопкам редактирования
            const editButtons = document.querySelectorAll('.edit-btn');
            editButtons.forEach(button => {
                button.addEventListener('click', function() {
                    alert('Функция редактирования будет реализована в полной версии');
                });
            });
            
            // Обработка отправки формы
            const form = document.querySelector('form');
            form.addEventListener('submit', function(e) {
               // e.preventDefault();
                alert('Статья успешно добавлена!');
                //form.reset();
            });
            
            // Обработка навигации в сайдбаре
            const navLinks = document.querySelectorAll('.admin-nav a');
            navLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    if (this.getAttribute('href') === '#') {
                        e.preventDefault();
                    }
                    
                    navLinks.forEach(l => l.classList.remove('active'));
                    this.classList.add('active');
                });
            });
            
            // Загрузка аватара
            const avatarInput = document.getElementById('avatar-input');
            const avatarPreview = document.getElementById('avatar-preview');
            const previewAvatarImg = document.getElementById('preview-avatar-img');
            const adminAvatarImg = document.getElementById('admin-avatar-img');
            
            if (avatarInput && previewAvatarImg && adminAvatarImg) {
                avatarInput.addEventListener('change', function(e) {
                    const file = e.target.files[0];
                    if (file) {
                        const reader = new FileReader();
                        
                        reader.onload = function(e) {
                            // Обновляем превью в форме
                            previewAvatarImg.src = e.target.result;
                            
                            // Обновляем аватар в шапке
                            adminAvatarImg.src = e.target.result;
                        }
                        
                        reader.readAsDataURL(file);
                    }
                });
            }
            
            // Клик по аватару в форме открывает загрузку
            if (avatarPreview && avatarInput) {
                avatarPreview.addEventListener('click', function() {
                    avatarInput.click();
                });
            }
            
            // Клик по аватару в шапке тоже открывает загрузку
            if (adminAvatarImg && avatarInput) {
                adminAvatarImg.addEventListener('click', function() {
                    avatarInput.click();
                });
            }
            
            // Обработка загрузки изображения для статьи
            const postImageInput = document.getElementById('post-image');
            if (postImageInput) {
                postImageInput.addEventListener('change', function(e) {
                    const file = e.target.files[0];
                    if (file) {
                        console.log('Изображение статьи загружено:', file.name);
                    }
                });
            }
        });

        // Добавьте это в ваш document.addEventListener('DOMContentLoaded', function() {
// Прокрутка при клике на меню
const navLinks = document.querySelectorAll('.admin-nav a');
navLinks.forEach(link => {
    link.addEventListener('click', function(e) {
        const href = this.getAttribute('href');
        if (href && href.startsWith('#')) {
            e.preventDefault();
            const target = document.querySelector(href);
            if (target) target.scrollIntoView({ behavior: 'smooth' });
        }
    });
});
    </script>
</body>
</html>