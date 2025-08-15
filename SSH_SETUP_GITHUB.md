# 🔐 Настройка SSH для GitHub

## 1. Генерация SSH ключа

Если у вас еще нет SSH ключа, создайте его:

```bash
ssh-keygen -t ed25519 -C "your-email@example.com"
```

Или для старых систем:
```bash
ssh-keygen -t rsa -b 4096 -C "your-email@example.com"
```

## 2. Копирование публичного ключа

```bash
# Для macOS
cat ~/.ssh/id_ed25519.pub | pbcopy

# Для Linux
cat ~/.ssh/id_ed25519.pub | xclip -selection clipboard

# Или просто выведите на экран и скопируйте вручную
cat ~/.ssh/id_ed25519.pub
```

## 3. Добавление ключа в GitHub

1. Перейдите в GitHub: https://github.com/settings/keys
2. Нажмите "New SSH key"
3. Вставьте скопированный ключ
4. Дайте ему название (например: "LAND GROU Project")
5. Нажмите "Add SSH key"

## 4. Проверка SSH соединения

```bash
ssh -T git@github.com
```

Должно вывести: "Hi ZemerIhor! You've successfully authenticated..."

## 5. Запуск автоматической настройки

После добавления SSH ключа в GitHub:

```bash
# Перейдите в проект
cd /Users/flstack/Desktop/devilbox/data/www/astanasultangamevip/casino

# Сделайте скрипт исполняемым
chmod +x setup_git.sh

# Запустите настройку
./setup_git.sh
```

## 6. Ручная настройка (если нужно)

Если автоматический скрипт не сработал:

```bash
# Инициализация
git init
git branch -M main

# Добавление remote
git remote add origin git@github.com:ZemerIhor/landgrou.git

# Первый коммит
git add .
git commit -m "Initial commit: LAND GROU - Ukrainian Peat Company"

# Пуш
git push -u origin main
```

## 🎯 Результат

После успешной настройки:
- ✅ Репозиторий: https://github.com/ZemerIhor/landgrou
- ✅ Весь код проекта в GitHub
- ✅ SSH подключение настроено
- ✅ Готов к деплою и разработке

## 📝 Полезные команды

```bash
# Проверить статус
git status

# Добавить изменения
git add .
git commit -m "Описание изменений"
git push

# Проверить remote
git remote -v

# История коммитов
git log --oneline
```
