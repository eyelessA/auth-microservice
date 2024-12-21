#!/bin/sh

#Генерация ключа шифрования
php artisan key:generate
# Сбилдим фронт
npm run build

# Запуск тестов
echo "Запускаю тесты..."
./vendor/bin/phpunit --configuration phpunit.xml

# Проверка, прошли ли тесты
if [ $? -eq 0 ]; then
    echo "Тесты прошли успешно."

    # Проверка, выполнены ли миграции
    if [ ! -f /var/www/storage/migrations_done ]; then
        echo "Выполняю миграции и сиды..."
        php artisan migrate --seed
        # Создаем файл-индикатор, чтобы миграции не выполнялись повторно
        touch /var/www/storage/migrations_done
    else
        echo "Миграции уже выполнены. Пропускаю."
    fi

    # Запускаем основной процесс (например, app-fpm)
    exec php-fpm
else
    echo "Тесты не прошли. Прекращаю выполнение."
    exit 1
fi
