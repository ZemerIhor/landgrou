# 🏢 LAND GROU - Українська компанія з видобутку торфу

[![Laravel](https://img.shields.io/badge/Laravel-10.x-red.svg)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.1+-blue.svg)](https://php.net)
[![Filament](https://img.shields.io/badge/Filament-3.x-orange.svg)](https://filamentphp.com)
[![Tailwind CSS](https://img.shields.io/badge/Tailwind%20CSS-3.x-38B2AC.svg)](https://tailwindcss.com)

## 📖 Про проект

**LAND GROU** — провідна українська компанія з видобутку та переробки торфу, що базується в Рівненській області. Цей веб-сайт представляє нашу продукцію торф'яних брикетів та послуги експорту.

### 🎯 Основні функції

- 🛒 **Інтернет-магазин** - повний каталог торф'яних брикетів
- 📱 **Responsive дизайн** - адаптивний під всі пристрої  
- 🌐 **Українська локалізація** - повністю україномовний інтерфейс
- ⚡ **Швидкодія** - оптимізовано для високої продуктивності
- 🔐 **Адмін-панель** - зручне управління контентом через Filament
- 📧 **Форми зв'язку** - інтеграція для обробки замовлень
- 📝 **Блог та відгуки** - контент-маркетинг
- 🎨 **Сучасний UI/UX** - професійний дизайн

## 🛠️ Технології

### Backend
- **PHP 8.1+** - сучасна версія PHP
- **Laravel 10.x** - потужний PHP фреймворк
- **MySQL** - база даних
- **Filament 3.x** - адмін-панель

### Frontend  
- **Blade Templates** - шаблонізатор Laravel
- **Tailwind CSS 3.x** - utility-first CSS фреймворк
- **Alpine.js** - легкий JavaScript фреймворк
- **Vite** - швидка збірка ресурсів

### Інтеграції
- **Responsive Images** - оптимізація зображень
- **SEO оптимізація** - мета-теги, структурована розмітка
- **Форми замовлень** - обробка заявок клієнтів

## 🚀 Встановлення

### Системні вимоги
- PHP 8.1 або вище
- Composer
- Node.js та npm
- MySQL 5.7+

### Крок 1: Клонування репозиторію
```bash
git clone git@github.com:ZemerIhor/landgrou.git
cd landgrou
```

### Крок 2: Встановлення залежностей
```bash
# PHP залежності
composer install

# JavaScript залежності  
npm install
```

### Крок 3: Налаштування середовища
```bash
# Копіювання файлу налаштувань
cp .env.example .env

# Генерація ключа додатку
php artisan key:generate
```

### Крок 4: Налаштування бази даних
Відредагуйте `.env` файл:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=landgrou
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

### Крок 5: Міграції та сідери
```bash
# Виконання міграцій
php artisan migrate

# Налаштування зберігання
php artisan storage:link

# Налаштування дозволів
chmod -R 775 storage bootstrap/cache
```

### Крок 6: Збірка ресурсів
```bash
# Розробка
npm run dev

# Продакшн
npm run build
```

### Крок 7: Запуск
```bash
# Локальний сервер розробки
php artisan serve
```

Сайт буде доступний за адресою: `http://localhost:8000`

## 🔧 Додаткові налаштування

### Створення адміністратора
```bash
php artisan make:filament-user
```

### Очищення кешу
```bash
php artisan config:clear
php artisan cache:clear
php artisan view:clear
```

### Оптимізація (продакшн)
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## 📁 Структура проекту

```
landgrou/
├── app/                    # Основний код додатку
│   ├── Http/Controllers/   # Контролери
│   ├── Models/            # Моделі Eloquent
│   ├── Filament/          # Адмін-панель Filament
│   └── ...
├── database/              # Міграції та сідери
├── lang/uk/              # Українська локалізація
├── public/               # Публічні ресурси
├── resources/            # Вьюхи, CSS, JS
│   ├── views/           # Blade шаблони
│   ├── css/            # Tailwind CSS
│   └── js/             # JavaScript
├── routes/              # Маршрути
└── storage/            # Завантаження та кеш
```

## 🌐 Локалізація

Проект повністю локалізований українською мовою:

- `lang/uk/auth.php` - аутентифікація
- `lang/uk/validation.php` - валідація форм  
- `lang/uk/messages.php` - інтерфейсні повідомлення
- `lang/uk/filament/` - адмін-панель

## 🔐 Безпека

- CSRF захист
- XSS захист
- SQL injection захист (Eloquent ORM)
- Валідація всіх форм
- Обмеження швидкості запитів

## 📱 Responsive дизайн

Сайт адаптивний та працює на:
- 📱 Мобільних телефонах
- 📟 Планшетах  
- 💻 Ноутбуках
- 🖥️ Настільних комп'ютерах

## 🎨 UI/UX особливості

- Сучасний дизайн з використанням Tailwind CSS
- Плавні анімації та переходи
- Інтуїтивна навігація
- Швидке завантаження сторінок
- Оптимізована система зображень

## 📞 Контакти

**ТОВ "Land Grou"**
- 🌍 Сайт: [land-grou.com](https://land-grou.com)
- 📧 Email: info@land-grou.com
- 📍 Адреса: Рівненська область, Україна

## 📄 Ліцензія

Цей проект є власністю ТОВ "Land Grou". Всі права захищені.

## 🤝 Розробка

Проект розроблено з використанням найкращих практик Laravel та сучасних веб-технологій.

### Команда розробки
- Backend: Laravel + PHP
- Frontend: Tailwind CSS + Alpine.js  
- Адмін-панель: Filament PHP
- Локалізація: Українська мова

---

⭐ **Якщо вам сподобався проект, поставте зірочку!**
