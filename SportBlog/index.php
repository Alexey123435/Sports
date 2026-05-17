<?
    require "core.php";

    if(isset($_GET['category'])){
    $allPosts = $conn -> query("SELECT `users`.*, `posts`.*
                FROM `users` 
	            LEFT JOIN `posts` ON `posts`.`userId` = `users`.`id` WHERE `users`.`role` = '2'
AND `posts`.`category` = '{$_GET['category']}'");
}else{
    $allPosts = $conn -> query("SELECT `users`.*, `posts`.*
                FROM `users` 
	            LEFT JOIN `posts` ON `posts`.`userId` = `users`.`id` WHERE `users`.`role` = '2'");
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SportVibe</title>
    <link rel="icon" href="iconka.jpg" type="image">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="wrapper">
        <header>
            <div class="head">
                <a href="../index.php"><p class="logo">SportVibe</p></a>
                <ul class="menu">
                    <li><a href="../SportBlog/index.php">Главная</a></li>
                    <li><a href="html/about.php">О нас</a></li>
                    <li><a href="html/contacts.php">Контакты</a></li>
                    <li><a href="pravila/pravila.php">Правила</a></li>
                    <?
                        if(!isset($_SESSION['user'])){
                    ?>
                        <li><a href="Registration/reg.php">Войти</a></li>
                    <?}else{
                        if($_SESSION['user']['role'] == 1){
                        ?>
                            <li><a href="Users/users.php">Профиль</a></li> 
                        <?}else{?>
                            <li><a href="Admin/admin.php">Админ-панель</a></li> 
                        <?}   
                    }?>
                </ul>
            </div>
        </header>
        
        <main>
            <div class="blog-header">
                <h1>Самый лучший блог о спорте</h1>
                <p>Всё самое лучшее и интересное здесь</p>
            </div>
            <div class="filter">
                <a href="index.php">Все</a>
                <a href="index.php?category=Хоккей">Хоккей</a>
                <a href="index.php?category=Биатлон">Биатлон</a>
                <a href="index.php?category=Волейбол">Волейбол</a>
                <a href="index.php?category=Футбол">Футбол</a>
                <a href="index.php?category=Баскетбол">Баскетбол</a>
                <a href="index.php?category=Другое">Другое</a>
            </div>

            <div class="blog-posts">
                <!-- Пост 1 -->
                <?
                    foreach ($allPosts as $key => $value) {
                ?>
                <article class="post">
                    <div class="post-img" style="background-image: url('image/<?=$value['img']?>');">
                    </div>
                    <div class="post-content">
                        <h2><?=$value['title']?></h2>
                        <div class="post-meta"><?=$value['dateUpload']?></div>
                        <h3 class="post-excerpt"><?=$value['category']?></h3>
                        <p class="post-excerpt"><?=mb_substr($value['desc'], 0, 200) . '...'?></p>
                        <a href="Ostate/Ostate.php?id=<?=$value['id']?>" class="read-more">Читать далее</a>
                    </div>
                </article>
                <?}?>
                <!-- Пост 2
                 <article class="post">
                    <div class="post-img" style="background-image: url('../image/');">
                    </div>
                    <div class="post-content">
                        <h2>Овечкин Бьёт Все Рекорды НХЛ</h2>
                        <div class="post-meta">25 ноября 2025</div>
                        <p class="post-excerpt">Овечкин бьет все рекорды НХЛ: новый триумф в карьере великого снайпера.
                     Вся хоккейная планета следит за тем, как Алксандр Овечкин преодолевает одну
                     веху за другой. В очередном матче он установил новый исторический достижение,
                     добавив свое имя в еще одну строку рекордов лиги.</p>
                        <a href="Ostate/Ostate.php" class="read-more">Читать далее</a>
                    </div>
                </article>


                 <article class="post">
                    <div class="post-img2">
                    </div>
                    <div class="post-content">
                        <h2>Воллейбол, «Омичка» Снова Самая Лучшая?</h2>
                        <div class="post-meta">26 ноября 2025</div>
                        <p class="post-excerpt">ВК «Омичка» уже несколько сезонов подряд уверенно занимает лидирующие позиции в российском
                         женском волейболе. Этот коллектив славится своей стабильностью, высоким уровнем профессионализма
                          и яркой игровой дисциплиной, что позволяет им оставаться на вершине.</p>
                        <a href="Ostate2/Ostate2." class="read-more">Читать далее</a>
                    </div>
                </article>
                
                <article class="post">
                    <div class="post-img3">
                    </div>
                    <div class="post-content">
                        <h2>Биатлон 2025/2026 – Открытие Нового Сезона</h2>
                        <div class="post-meta">27 ноября 2025</div>
                        <p class="post-excerpt">Новый сезон российского биатлона 2025/2026 начинает свои
                         захватывающие соревнования с Чемпионата России – главного национального турнира, 
                         где определяются лучшие спортсмены страны. Этот этап открывает биатлонный год и служит ключевым рубежом для отбора в сборную.</p>
                        <a href="Ostate3/Ostate3.html" class="read-more">Читать далее</a>
                    </div>
                </article> -->
            </div>
        </main>
        
<footer>
      <div class="foot1">
        <p class="logo2">SportVibe</p>
      </div>
      <ul class="foot2">
              <li><a href="../SportBlog/index.php">Главная</a></li>
              <li><a href="html/about.php">О нас</a></li>
      </ul>
      <div class="foot2">
        <li><a href="html/contacts.php">Контакты</a></li>
        <li><a href="pravila/pravila.php">Правила</a></li>
      </div>
      <div class="foot4">
         <a href="https://maxln.ru/8nucVX" target="_blank" rel="noopener"><img src="max.png" alt="Max"></a>
      </div>
    </footer>
    </div>
</body>
</html>