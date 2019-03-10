VERBOSE ?= 0

COMMIT = $(shell git rev-parse --short HEAD)
TIMESTAMP = $(shell date +%Y%m%d%H%M%S)

Q = $(if $(filter 1,${VERBOSE}), , @)
M = $(shell printf "\033[32;1m▶\033[0m")

include .env

.DEFAULT_GOAL := help

.PHONY: version
version:
	$Q echo $(TIMESTAMP)-$(COMMIT)

.PHONY: help
help: ; $(info $(M) Usage:)
	$Q echo "make run                      build environment"
	$Q echo "make tests                    run tests"

.PHONY: up
up: ; $(info $(M) Starting containers:)
	$Q docker-compose up -d

.PHONY: down
down: ; $(info $(M) Shutting down containers:)
	$Q docker-compose down

.PHONY: composer
composer: ; $(info $(M) Installing dependencies:)
	$Q docker-compose exec -T php composer install --ansi --no-interaction

.PHONY: run
run: up composer ; $(info $(M) Environment has been built succesfully:)

.PHONY: styles-check
styles-check: ; $(info $(M) Checking coding style:)
	$Q docker-compose exec -T php vendor/bin/phpcs -ps

.PHONY: tests
tests: run styles-check ; $(info $(M) Running tests:)
	$Q docker-compose exec -T minio mkdir -p /data/$(S3_BUCKET)
	$Q docker-compose exec -T php vendor/bin/phpunit
