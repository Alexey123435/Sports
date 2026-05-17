<?
  require "../core.php";

  if(isset($_POST['logBut'])){
    $login = $_POST['login'];
    $pass = $_POST['pass'];

    $allUsers = $conn -> query("SELECT * FROM `users` WHERE `login` = '$login' AND `pass` = '$pass'");
    
    if($allUsers->num_rows > 0){
      $thisUser = $conn -> query("SELECT * FROM `users` WHERE `login` = '$login'");
      $thisUser = $thisUser -> fetch_assoc();
      $_SESSION['user'] = [
        'id' => $thisUser['id'],
        'email' => $thisUser['email'],
        'login' => $thisUser['login'],
        'pass' => $thisUser['pass'],
        'role' => $thisUser['role'],
        'dateReg' => $thisUser['dateReg']
      ];

      if($_SESSION['user']['role'] == 1){
        header("location:../Users/users.php");
      }else{
        header("location:../Admin/admin.php");
      }
    }
  }
?>

<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <title>Авторизация</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap">
  <link rel="stylesheet" href="login.css">
  <link rel="icon" href="iconka.jpg" type="image">
</head>
<body>
  <header>
         <div class="head">
        <a href=""><p class="logo">SportVibe</p></a>
    <ul class="menu">
          <li><a href="#">Войдите в личный аккаунт</a></li>
    </ul>
  </header>

  <div class="container">
    <div class="form-wrapper">
      <div id="successMessage" class="success-message">
        Авторизация прошла успешно! Теперь вы вошли в систему.
      </div>
      <form method="post">
      <h2>Авторизация</h2>
        <div class="form-group">
          <input type="text" class="form-input" id="login" placeholder=" " required name="login">
          <label for="login" class="form-label">Введите логин</label>
          <div class="error" id="emailError">Пожалуйста, введите корректный логин</div>
        </div>  
        <div class="form-group">
          <input type="password" class="form-input" id="password" placeholder=" " required name="pass">
          <label for="password" class="form-label">Введите Пароль</label>
          <div class="error" id="passwordError">Пароль должен содержать не менее 6 символов</div>
        </div>
        <button type="submit" class="form-btn" name="logBut">Авторизоваться</button>
        <div class="form-footer">
          <p>У вас нет аккаунта? <a href="../registration/reg.php">Регистрация</a></p>
        </div>
      </form>
    </div>
  </div>
    <script src="login.js"></script>
</body>
</html>