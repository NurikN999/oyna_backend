# Oyna API
Данный проект является API для приложения Oyna.kz

## Начало работы
Эти инструкции помогут вам получить копию проекта и запустить его на вашей локальной машине для разработки и тестирования. Смотрите раздел о развертывании для получения информации о том, как развернуть проект в живую систему.

### Требования

| Технология | Версия |
|------------|--------|
|   PHP      | 8.1^   |
|   Composer | latest |
|MySQL(опционально)| latest|

### Установка

Пошаговый процесс установки и настройки локальной разработочной среды

1. Клонирование репозитория
```bash
    git clone https://github.com/NurikN999/oyna_backend.git
    cd oyna_backend
```

2. Установка зависимостей через composer
```bash
    composer install
```

3. Создание файла для переменных среды
```bash
    cp .env.example .env
```

4. Генерация ключа приложения
```bash
    php artisan key:generate
```

5. Настройка базы данных и других переменных среды в .env файле
```bash
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=homestead
    DB_USERNAME=homestead
    DB_PASSWORD=secret
```

6. Миграция базы данных. Заполнение базы данных путем запуска сидеров
```bash
    php artisan migrate
    php artisan db:seed
```

7. Генерация документации API
```bash
    php artisan l5-swagger:generate
```

8. Генерация секретного ключа для JWT токенов
```bash
    php artisan jwt:secret
```

### Docker

В ближайшем времени добавлю запуск проекта путем контейнеризации...
