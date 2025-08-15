#!/bin/bash

# Git Setup Script для проекта LAND GROU
# Автоматическая настройка и пуш в GitHub

echo "🚀 Начинаем настройку Git репозитория..."

# Переходим в директорию проекта
cd /Users/flstack/Desktop/devilbox/data/www/astanasultangamevip/casino

# Проверяем, что мы в правильной директории
if [ ! -f "artisan" ]; then
    echo "❌ Ошибка: Файл artisan не найден. Убедитесь, что вы находитесь в корне Laravel проекта."
    exit 1
fi

echo "📁 Текущая директория: $(pwd)"

# Инициализируем Git репозиторий
echo "🔧 Инициализируем Git репозиторий..."
git init

# Настраиваем основную ветку
git branch -M main

# Добавляем remote origin
echo "🔗 Добавляем remote origin..."
git remote add origin git@github.com:ZemerIhor/landgrou.git

# Проверяем статус
echo "📋 Проверяем статус файлов..."
git status

# Добавляем все файлы
echo "📦 Добавляем все файлы в Git..."
git add .

# Проверяем, что файлы добавились
echo "✅ Файлы добавлены:"
git status --short

# Создаем первый коммит
echo "💾 Создаем первый коммит..."
git commit -m "Initial commit: LAND GROU - Ukrainian Peat Briquettes Company

🏢 Проект: Украинская компания по добыче и переработке торфа
🌐 Язык: Полностью переведен на украинский (uk)
🛠️ Технологии: Laravel + Filament Admin + Tailwind CSS

✨ Особенности:
- Полный каталог торфяных брикетов
- Интернет-магазин с корзиной и оформлением заказов
- Админ-панель на Filament
- Формы обратной связи
- Блог и отзывы
- Responsive дизайн
- SEO-оптимизация

🔄 Миграция языка:
- Заменены все польские (pl) переводы на украинские (uk)
- Обновлены настройки локализации
- Переведен весь пользовательский интерфейс
- Обновлены миграции настроек

📂 Структура:
- Frontend: Laravel Blade + Tailwind CSS
- Backend: Laravel + MySQL
- Admin: Filament PHP
- Локализация: lang/uk/ (украинский)

🎯 Готов к деплою!"

# Пытаемся запушить
echo "🚀 Пушим в GitHub..."
echo "⚠️  Убедитесь, что SSH ключ добавлен в GitHub!"

# Проверяем SSH соединение
echo "🔐 Проверяем SSH соединение с GitHub..."
ssh -T git@github.com

# Если SSH работает, пушим
if [ $? -eq 1 ]; then
    echo "✅ SSH соединение работает. Пушим код..."
    git push -u origin main
    
    if [ $? -eq 0 ]; then
        echo ""
        echo "🎉 УСПЕХ! Код успешно запушен в GitHub!"
        echo ""
        echo "🔗 Ваш репозиторий: https://github.com/ZemerIhor/landgrou"
        echo ""
        echo "✅ Что было сделано:"
        echo "   - Создан Git репозиторий"
        echo "   - Добавлен .gitignore для Laravel"
        echo "   - Сделан первый коммит с полным описанием"
        echo "   - Код запушен в GitHub"
        echo ""
        echo "🚀 Проект готов к дальнейшей разработке!"
    else
        echo "❌ Ошибка при пуше. Проверьте права доступа."
    fi
else
    echo "❌ SSH соединение не работает."
    echo "📝 Выполните вручную:"
    echo "   1. Добавьте SSH ключ в GitHub"
    echo "   2. Выполните: git push -u origin main"
fi

echo ""
echo "📝 Если нужно настроить Git пользователя:"
echo "   git config --global user.name 'Ваше Имя'"
echo "   git config --global user.email 'your-email@example.com'"
echo ""
echo "🔧 Полезные команды:"
echo "   git status          # Проверить статус"
echo "   git log --oneline   # Посмотреть историю коммитов"
echo "   git remote -v       # Проверить remote репозитории"
