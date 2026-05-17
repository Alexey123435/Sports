<?
  require "../core.php";

  $_SESSION['error']['reg'] = "";

  if(isset($_POST['regBut'])){
    $email = $_POST['email'];
    $login = $_POST['login'];
    $pass = $_POST['pass'];
    $dateReg = date("Y-m-d");

    $allLogins = $conn -> query("SELECT * FROM `users` WHERE `login` = '$login'");
    if($allLogins -> num_rows == 0){
      $conn -> query("INSERT INTO `users`(`email`, `login`, `pass`, `dateReg`) VALUES ('$email', '$login', '$pass','$dateReg')");
      header("location:../Login/login.php");
    }else{
      $_SESSION['error']['reg'] = "Такой логин уже существует!";
    }
  }
?>

<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <title>Регистрация</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap">
  <link rel="stylesheet" href="reg.css">
  <link rel="icon" href="iconka.jpg" type="image">
</head>
<body>
  <header>
         <div class="head">
        <a href=""><p class="logo">SportVibe</p></a>
    <ul class="menu">
          <li><a href="#">Создайте личный аккаунт</a></li>
    </ul>
  </header>

  <div class="container">
    <div class="form-wrapper">
      <div id="successMessage" class="success-message">
        Регистрация прошла успешно! Теперь вы можете войти в систему.
      </div>
      <form method="post">
      <h2>Регистрация</h2>
        <div class="form-group">
          <input type="email" class="form-input" id="email" placeholder=" " name="email" required>
          <label for="email" class="form-label">Введите Email</label>
          <div class="error" id="emailError">Пожалуйста, введите корректный email</div>
        </div>  
        <div class="form-group">
          <input type="login" class="form-input" id="login" placeholder=" " name="login" required minlength="4">
          <label for="login" class="form-label">Введите логин</label>
          <div class="error" id="passwordError">Логин должен содержать не менее 4 символов</div>
        </div>
        <div class="form-group">
          <input type="password" class="form-input" id="confirmPassword" placeholder=" " name="pass" required minlength="6">
          <label for="confirmPassword" class="form-label">Придумайте Пароль</label>
          <div class="error" id="confirmPasswordError"><?=$_SESSION['error']['reg']?></div>
        </div>
        <button type="submit" class="form-btn" name="regBut">Зарегистрироваться</button>
        <div class="form-footer">
          <p>Уже есть аккаунт? <a href="../Login/login.php">Войти</a></p>
        </div>
      </form>
    </div>
  </div>
     <!-- <script src="reg.js"></script> -->
</body>
</html>