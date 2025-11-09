# NuxGame

Laravel game application with Repository-Service Pattern

## Quick Start

```bash
# Перше встановлення (все автоматично)
make install

# Відкрити: http://localhost:8077
```

## Commands

```bash
make help        # Показати всі команди
make up          # Запустити контейнери
make down        # Зупинити контейнери
make logs        # Показати логи
make shell       # Увійти в контейнер
make build       # Зібрати assets
make migrate     # Запустити міграції
make fresh       # Очистити БД і запустити міграції

# З параметрами
make artisan cmd="cache:clear"
make composer cmd="require package/name"
make npm cmd="run dev"
```

## Tech Stack

- PHP 8.4 + Laravel 12
- MySQL 8.0
- Docker + Nginx
- Vite + Tailwind CSS

**Adminer:** http://localhost:8078 (db / nuxgame_user / password)
