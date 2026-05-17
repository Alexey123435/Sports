document.addEventListener('DOMContentLoaded', function() {
            // Переключение вкладок с плавной прокруткой
            const navLinks = document.querySelectorAll('.user-nav a');
            const tabContents = document.querySelectorAll('.tab-content');
            
            navLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    // Если это кнопка "Выйти", не обрабатываем
                    if (this.getAttribute('href') === '../index.html') return;
                    
                    e.preventDefault();
                    
                    const tabId = this.dataset.tab;
                    
                    // Обновляем активные элементы
                    navLinks.forEach(l => l.classList.remove('active'));
                    tabContents.forEach(c => c.classList.remove('active'));
                    
                    this.classList.add('active');
                    const targetTab = document.getElementById(`${tabId}-tab`);
                    targetTab.classList.add('active');
                    
                    // Плавная прокрутка до нужного раздела
                    targetTab.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                });
            });
            
            // Обработка кнопок действий
            const actionBtns = document.querySelectorAll('.action-btn, .add-to-cart, .remove-btn');
            
            actionBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    const action = this.textContent.trim();
                    
                    if (action === 'Просмотр') {
                        const orderId = this.closest('.order-item').querySelector('h4').textContent;
                        alert(`Детали заказа: ${orderId}`);
                    } else if (action === 'Повторить') {
                        const orderId = this.closest('.order-item').querySelector('h4').textContent;
                        alert(`Повтор заказа: ${orderId}`);
                    } else if (action === 'В корзину') {
                        const productName = this.closest('.wishlist-item').querySelector('.wishlist-name').textContent;
                        alert(`Товар "${productName}" добавлен в корзину`);
                    } else if (action === 'Удалить') {
                        const productName = this.closest('.wishlist-item').querySelector('.wishlist-name').textContent;
                        if (confirm(`Удалить "${productName}" из избранного?`)) {
                            this.closest('.wishlist-item').remove();
                        }
                    }
                });
            });
            
            // Кнопка редактирования профиля
            const editProfileBtn = document.querySelector('.edit-btn');
            
            editProfileBtn.addEventListener('click', function() {
                alert('Редактирование профиля');
            });
            
            // Кнопка сохранения личной информации
            const savePersonalInfoBtn = document.querySelector('#personal-info-tab .save-btn');
            
            savePersonalInfoBtn.addEventListener('click', function() {
                alert('Личная информация сохранена');
            });
            
            // Кнопка сохранения настроек
            const saveSettingsBtn = document.querySelector('#settings-tab .save-btn');
            
            saveSettingsBtn.addEventListener('click', function() {
                alert('Настройки сохранены');
            });
            
            // Автоматическая прокрутка к активному разделу при загрузке страницы
            if (window.location.hash) {
                const hash = window.location.hash.substring(1);
                const targetTab = document.getElementById(`${hash}-tab`);
                if (targetTab) {
                    // Обновляем активные элементы
                    navLinks.forEach(l => l.classList.remove('active'));
                    tabContents.forEach(c => c.classList.remove('active'));
                    
                    // Активируем нужную вкладку
                    const activeLink = document.querySelector(`.user-nav a[data-tab="${hash}"]`);
                    if (activeLink) {
                        activeLink.classList.add('active');
                        targetTab.classList.add('active');
                        
                        // Прокручиваем до нужного раздела
                        setTimeout(() => {
                            targetTab.scrollIntoView({
                                behavior: 'smooth',
                                block: 'start'
                            });
                        }, 100);
                    }
                }
            }
        });