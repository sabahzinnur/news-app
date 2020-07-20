.PHONY: help
PATH := $(PATH):$(shell pwd)/bin
RESET=\033[0m
GREEN=\033[92m
YELLOW=\033[1;33m
#LOGFILE=storage/logs/laravel.log

help:                 ## Show this help
	@fgrep -h "##" $(MAKEFILE_LIST) | fgrep -v fgrep | sed -e 's/\\$$//' | sed -e 's/##//'

install:              ## Install project and initialize
	@echo "${YELLOW}Creating environment file...${RESET}"
	@cp .env.example .env
	@echo "${YELLOW}Creating containers...${RESET}"
	@docker-compose up -d --build --remove-orphans --force-recreate
	@echo "${YELLOW}Installing dependencies...${RESET}"
	@make dependencies
	@echo "${YELLOW}Creating private keys...${RESET}"
	@make token
	@echo "${YELLOW}Resetting cache files...${RESET}"
	@make clear
	@echo "${YELLOW}Migrate database...${RESET}"
	@make migrate
	@make seeds
	@make index
	@make passport
	@make swagger
	@make buckets
	@docker ps
	@echo "${GREEN}Install complete.${RESET}"

refresh:
	@make clear
	@docker-compose exec php php artisan migrate:fresh
	@make seeds

buckets:
	@mkdir -p storage/minio/temp
	@mkdir -p storage/minio/static
	@echo "${GREEN}Buckets created.${RESET}"


passport:
	@docker-compose exec php php artisan passport:install

rebuild:              ## Rebuild all project containers
	@docker-compose up -d --build --remove-orphans --force-recreate
	@make clear
	@make migrate
	@docker ps

debug:                ## Run containers in no-demonize mode
	@docker-compose up --build --remove-orphans --force-recreate
	@docker ps

up:                   ## Run project dev instance in Docker
	@docker-compose up -d
	@docker ps

kill:                 ## Kill ALL Docker running instances
	@docker-compose down

down:
	@docker kill $$(docker ps -q)

dependencies:         ## Install composer dependencies
	@docker-compose exec php composer install --no-interaction --prefer-dist --optimize-autoloader
	@docker-compose exec php php artisan cache:clear

seeds:
	@docker-compose exec php php artisan sync:news --force

index:                ## Index eloquent models
  @docker-compose exec php php artisan scout:import "App\News"

restart: down up      ## Restart docker containers
	@echo "${GREEN}Restarted.${RESET}"

clear:                ## Clear laravel cache
	@docker-compose exec php php artisan config:clear
	@docker-compose exec php php artisan route:clear
	@docker-compose exec php php artisan view:clear

update:               ## Update composer dependencies inside Docker
	@docker-compose exec php composer update

queue:                ## Run laravel queue listener
	@echo "${GREEN}Starting.${RESET}"
	@docker-compose exec php php artisan queue:listen

logs:                 ## Listen the log file
	@[ -f ./$(LOGFILE) ] && echo "${GREEN}Listening logs.${RESET}" && tail -f $(LOGFILE) || echo "${YELLOW}Log file not found.${RESET}"

drop:                 ## Drop ALL exited containers
	@docker rm -v $$(docker ps -aq -f status=exited)

prune:                ## Prune ALL images on host
	@docker rm -v $$(docker ps -aq -f status=exited)
	@docker image prune -a
	@docker system prune

token:                ## Generate new APP_KEY private key
	@docker-compose exec php php artisan key:generate

elk:                  ## Start environment with ELK stack
	@docker-compose -f docker-compose.yml -f docker-compose.elk.yml up -d
	@docker ps

xdebug:               ## Run PHP-FPM with XDebug extension
	@docker-compose -f docker-compose.yml -f docker-compose.xdebug.yml build
	@docker-compose -f docker-compose.yml -f docker-compose.xdebug.yml up -d

coverage:             ## Run Tests and save coverage to report
	@docker-compose exec php composer coverage

stats:                ## Show Docker containers stats table
	@docker stats --format "table {{.Name}}\t{{.CPUPerc}}\t{{.MemUsage}}\t{{.NetIO}}"

migrate:              ## Run and apply migrations
	@docker-compose exec php php artisan migrate --force

swagger:              ## Run swagger generator and resource publisher
	@docker-compose exec php php artisan l5-swagger:generate
