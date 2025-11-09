.PHONY: help install up down build rebuild logs shell composer artisan npm migrate fresh

help: ## Show this help
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-20s\033[0m %s\n", $$1, $$2}'

install: ## Install project (first time setup)
	docker-compose up -d --build
	docker-compose exec app composer install
	docker-compose exec app npm install
	@if [ ! -f .env ]; then cp .env.example .env; fi
	docker-compose exec app php artisan key:generate
	docker-compose exec app php artisan migrate
	docker-compose exec app npm run build
	@echo "\n✅ Project installed! Open http://localhost:8077"

up: ## Start containers
	docker-compose up -d

down: ## Stop containers
	docker-compose down

build: ## Build assets
	docker-compose exec app npm run build

rebuild: ## Rebuild Docker containers
	docker-compose up -d --build

logs: ## Show logs
	docker-compose logs -f

shell: ## Enter app container
	docker-compose exec app bash

composer: ## Run composer command (usage: make composer cmd="install")
	docker-compose exec app composer $(cmd)

artisan: ## Run artisan command (usage: make artisan cmd="migrate")
	docker-compose exec app php artisan $(cmd)

npm: ## Run npm command (usage: make npm cmd="run dev")
	docker-compose exec app npm $(cmd)

migrate: ## Run migrations
	docker-compose exec app php artisan migrate

fresh: ## Fresh migration with seed
	docker-compose exec app php artisan migrate:fresh