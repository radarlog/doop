COMMIT = $(shell git rev-parse --short HEAD)
TIMESTAMP = $(shell date +%Y%m%d%H%M%S)

M = $(shell printf "\033[32;1m▶\033[0m")

include .env

.SILENT:

.DEFAULT_GOAL := help

.PHONY: version
version:
	echo $(TIMESTAMP)-$(COMMIT)

.PHONY: help
help: ; $(info $(M) Usage:)
	echo "make run                      build environment"
	echo "make tests                    run tests"

.PHONY: up
up: ; $(info $(M) Starting containers:)
	docker-compose up -d

.PHONY: down
down: ; $(info $(M) Shutting down containers:)
	docker-compose down

.PHONY: composer
composer: ; $(info $(M) Installing dependencies:)
	docker-compose exec -T php composer validate --ansi --no-interaction --strict
	docker-compose exec -T php composer install --ansi --no-interaction

.PHONY: migrations
migrations: ; $(info $(M) Running migrations:)
	echo -n "Waiting for SQL container to be up and running"
	until docker-compose exec -T postgres pg_isready -h postgres --quiet ; \
        do \
            echo -n "." ; \
            sleep 1 ; \
        done
	echo ""
	docker-compose exec -T php bin/console migrations:migrate --no-interaction

.PHONY: run
run: up composer migrations ; $(info $(M) Environment has been built succesfully)

.PHONY: static-analyze
static-analyze: ; $(info $(M) Performing static analyze:)
	docker-compose exec -T php vendor/bin/phpstan.phar analyse
	docker-compose exec -T php vendor/bin/psalm --show-info=false

.PHONY: styles-check
styles-check: ; $(info $(M) Checking coding style:)
	docker-compose exec -T php vendor/bin/phpcs -ps

.PHONY: tests
tests: run styles-check static-analyze ; $(info $(M) Running tests:)
	docker-compose exec -T php vendor/bin/phpunit -d pcov.enabled=1
