<?
    require "../core.php";

    if(isset($_POST['sendText'])){
        $userId = $_SESSION['user']['id'];
        $text = $_POST['text'];
        $id = $_POST['idPost'];
        $dateUpload = date("Y-m-d");

        $conn -> query("INSERT INTO `comments`(`text`, `userId`, `postId`, `dateUpload`) VALUES ('$text','$userId','$id','$dateUpload')");
        $userStat = $conn -> query("SELECT * FROM `users` WHERE `id` = '{$_SESSION['user']['id']}'");
            foreach ($userStat as $key => $value) {
                $comm = $value['comments'];
                $comm++;
                $conn -> query("UPDATE `users` SET `comments`='$comm' WHERE `id` = '{$_SESSION['user']['id']}'");
            }

        header("location:../UsersPost/userpost.php");
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="userpost.css">
    <link rel="icon" href="../iconka.jpg" type="image">
    <title>SportVibe</title>
</head>
<body>
    <div class="wrapper">
        <header>
            <div class="head">
                <a href="../index.php"><p class="logo">SportVibe</p></a>
              <ul class="menu">
                <li><a href="../index.php">Главная</a></li>
                <li><a href="../Users/users.php">Вернуться в профиль</a></li>
              </ul>
            </div>
        </header>

        <div class="posts-container">
            <div class="text">
                <h1>Мои посты</h1>
            </div>
            <?$allUserPosts = $conn -> query("SELECT `posts`.*, `users`.*, `posts`.`id` AS 'postId'
FROM `posts` 
	LEFT JOIN `users` ON `posts`.`userId` = `users`.`id` WHERE `posts`.`userId` = '{$_SESSION['user']['id']}' ORDER BY `posts`.`id` DESC");
                if($allUserPosts -> num_rows == 0){?>
                <div class="text">
                    <p>У вас еще нет постов!</p>  
                </div>  
                <?}else{
                foreach ($allUserPosts as $key => $value) {?>
            <div class="post">
                <div class="post-header">
                    <img src="../image/<?=$value['avatar']?>" alt="logo" class="avatar">
                    <div class="info">
                        <h3><?=$_SESSION['user']['login']?></h3>
                        <div class="post-date"><?=$value['dateUpload']?></div>
                    </div>
                </div>
                <div class="text2">
                    <h1><?=$value['title']?></h1>
                </div>
                <img src="../image/<?=$value['img']?>" alt="Картинка" class="post-image">
                <div class="post-content">
                    <?=$value['desc']?>
                </div>
                
                <div class="rating-section">
                    <form class="rating-stars" method="post">
                        <button class="star" data-value="1" value="1" name="currentRatingValue">★</button>
                        <button class="star" data-value="2" value="2" name="currentRatingValue">★</button>
                        <button class="star" data-value="3" value="3" name="currentRatingValue">★</button>
                        <button class="star" data-value="4" value="4" name="currentRatingValue">★</button>
                        <button class="star" data-value="5" value="5" name="currentRatingValue">★</button>
                    </form>
                    <div class="rating-text">Оцените пост</div>
                </div>
                
                <div class="comments-section">
                    <form class="comment-form" method="post">
                            <input type="hidden" value="<?=$value['postId']?>" name="idPost">
                            <textarea class="comment-input" placeholder="Оставьте ваш комментарий..." name="text"></textarea>
                            <button class="comment-submit" type="submit" name="sendText">Отправить</button>
                        </form>
                        
                        <?
                        $allComments = $conn -> query("SELECT `posts`.*, `comments`.*, `users`.*
FROM `posts` 
	LEFT JOIN `comments` ON `comments`.`postId` = `posts`.`id` 
	LEFT JOIN `users` ON `comments`.`userId` = `users`.`id`
     WHERE `comments`.`postId` = '{$value['postId']}'");
                        foreach ($allComments as $key => $value) {
                    ?>
                    <div class="comments-list">
                        <div class="comment">
                            <div class="comment-header">
                                <span class="comment-author"><?=$value['login']?></span>
                                <span class="comment-date"><?=$value['dateUpload']?></span>
                            </div>
                            <div class="comment-text"><?=$value['text']?></div>
                        </div>
                    </div>
                    <?}?>
                </div>
            </div>
            <?}}?>
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
        <li><a href="../html/about.php">Контакты</a></li>
        <li><a href="../pravila/pravila.php">Правила</a></li>
      </div>
      <div class="foot4">
         <a href="https://maxln.ru/8nucVX" target="_blank" rel="noopener"><img src="max.png" alt=""></a>
      </div>
    </footer>
    </div>
   <script>
        // Функциональность для звезд рейтинга
        document.querySelectorAll('.rating-stars').forEach(starsContainer => {
            const stars = starsContainer.querySelectorAll('.star');
            let currentRating = 0;
            
            stars.forEach(star => {
                star.addEventListener('click', function() {
                    const value = parseInt(this.getAttribute('data-value'));
                    currentRating = value;
                    
                    // Обновляем отображение звезд
                    stars.forEach(s => {
                        const starValue = parseInt(s.getAttribute('data-value'));
                        if (starValue <= value) {
                            s.classList.add('active');
                        } else {
                            s.classList.remove('active');
                        }
                    });
                    
                    // Здесь можно отправить оценку на сервер
                    console.log(`Оценка: ${value} звезд`);
                });
                
                star.addEventListener('mouseover', function() {
                    const value = parseInt(this.getAttribute('data-value'));
                    
                    stars.forEach(s => {
                        const starValue = parseInt(s.getAttribute('data-value'));
                        if (starValue <= value) {
                            s.style.color = '#ffc107';
                        } else {
                            s.style.color = '#ddd';
                        }
                    });
                });
                
                star.addEventListener('mouseout', function() {
                    stars.forEach(s => {
                        const starValue = parseInt(s.getAttribute('data-value'));
                        if (starValue <= currentRating) {
                            s.style.color = '#ffc107';
                        } else {
                            s.style.color = '#ddd';
                        }
                    });
                });
            });
        });
        
        // Функциональность для комментариев
        // document.querySelectorAll('.comment-submit').forEach(button => {
        //     button.addEventListener('click', function() {
        //         const form = this.closest('.comment-form');
        //         const input = form.querySelector('.comment-input');
        //         const commentsList = form.closest('.comments-section').querySelector('.comments-list');
                
        //         if (input.value.trim() !== '') {
        //             // Создаем новый комментарий
        //             const comment = document.createElement('div');
        //             comment.className = 'comment';
                    
        //             const now = new Date();
        //             const dateString = now.toLocaleDateString('ru-RU');
                    
        //             comment.innerHTML = `
        //                 <div class="comment-header">
        //                     <span class="comment-author">Вы</span>
        //                     <span class="comment-date">${dateString}</span>
        //                 </div>
        //                 <div class="comment-text">${input.value}</div>
        //             `;
                    
        //             // Добавляем комментарий в начало списка
        //             commentsList.insertBefore(comment, commentsList.firstChild);
                    
        //             // Очищаем поле ввода
        //             input.value = '';
        //         }
        //     });
        // });
    </script>
</body>
</html>