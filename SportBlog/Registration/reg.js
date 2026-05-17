document.addEventListener('DOMContentLoaded', function() {
      const form = document.getElementById('registrationForm');
      const successMessage = document.getElementById('successMessage');
      
      // Элементы для валидации
      const fullNameInput = document.getElementById('fullName');
      const emailInput = document.getElementById('email');
      const phoneInput = document.getElementById('phone');
      const passwordInput = document.getElementById('password');
      const confirmPasswordInput = document.getElementById('confirmPassword');
      
      // Элементы ошибок
      const fullNameError = document.getElementById('fullNameError');
      const emailError = document.getElementById('emailError');
      const phoneError = document.getElementById('phoneError');
      const passwordError = document.getElementById('passwordError');
      const confirmPasswordError = document.getElementById('confirmPasswordError');
      
      // Функции валидации
      function validateFullName() {
        if (fullNameInput.value.trim() === '') {
          fullNameError.style.display = 'block';
          return false;
        } else {
          fullNameError.style.display = 'none';
          return true;
        }
      }
      
      function validateEmail() {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(emailInput.value)) {
          emailError.style.display = 'block';
          return false;
        } else {
          emailError.style.display = 'none';
          return true;
        }
      }
      
      function validatePhone() {
        // Если поле не пустое, проверяем формат
        if (phoneInput.value.trim() !== '') {
          const phoneRegex = /^(\+7|8)[0-9]{10}$/;
          const cleanedPhone = phoneInput.value.replace(/\D/g, '');
          
          if (!phoneRegex.test(cleanedPhone) && cleanedPhone.length > 0) {
            phoneError.style.display = 'block';
            return false;
          }
        }
        phoneError.style.display = 'none';
        return true;
      }
      
      function validatePassword() {
        if (passwordInput.value.length < 6) {
          passwordError.style.display = 'block';
          return false;
        } else {
          passwordError.style.display = 'none';
          return true;
        }
      }
      
      function validateConfirmPassword() {
        if (passwordInput.value !== confirmPasswordInput.value) {
          confirmPasswordError.style.display = 'block';
          return false;
        } else {
          confirmPasswordError.style.display = 'none';
          return true;
        }
      }
      
      // Слушатели событий для валидации в реальном времени
      fullNameInput.addEventListener('blur', validateFullName);
      emailInput.addEventListener('blur', validateEmail);
      phoneInput.addEventListener('blur', validatePhone);
      passwordInput.addEventListener('blur', validatePassword);
      confirmPasswordInput.addEventListener('blur', validateConfirmPassword);
      
      // Обработка отправки формы
      form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Валидация всех полей
        const isFullNameValid = validateFullName();
        const isEmailValid = validateEmail();
        const isPhoneValid = validatePhone();
        const isPasswordValid = validatePassword();
        const isConfirmPasswordValid = validateConfirmPassword();
        
        // Если все поля прошли валидацию
        if (isFullNameValid && isEmailValid && isPhoneValid && 
            isPasswordValid && isConfirmPasswordValid) {
          
          // Собираем данные формы
          const formData = {
            fullName: fullNameInput.value.trim(),
            email: emailInput.value.trim(),
            phone: phoneInput.value.trim() || 'Не указан',
            password: passwordInput.value
          };
          
          // В реальном приложении здесь был бы AJAX-запрос к серверу
          console.log('Данные для регистрации:', formData);
          
          // Показываем сообщение об успехе
          successMessage.style.display = 'block';
          
          // Очистка формы
          form.reset();
          
          // Через 3 секунды скрываем сообщение
          setTimeout(() => {
            successMessage.style.display = 'none';
          }, 5000);
        }
      });
      
      // Маска для телефона
      phoneInput.addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        
        if (value.length > 0) {
          if (value[0] === '7' || value[0] === '8') {
            value = value.substring(1);
          }
          
          let formattedValue = '+7';
          
          if (value.length > 0) {
            formattedValue += ' (' + value.substring(0, 3);
          }
          if (value.length > 3) {
            formattedValue += ') ' + value.substring(3, 6);
          }
          if (value.length > 6) {
            formattedValue += '-' + value.substring(6, 8);
          }
          if (value.length > 8) {
            formattedValue += '-' + value.substring(8, 10);
          }
          
          e.target.value = formattedValue;
        }
      });
    });