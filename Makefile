.PHONY: init up stop build ps config

DATE := $(git log -1 --format="%cd" --date=short | sed s/-//g)
COUNT := $(git rev-list --count HEAD)
COMMIT := $(git rev-parse --short HEAD)

VERSION := "${DATE}.${COUNT}_${COMMIT}"

export VERSION

ver:
	@echo ${VERSION}

init:
	mkdir -p mariadb/var/lib/mysql

up: stop init
	docker-compose up

stop:
	docker-compose stop

down:
	docker-compose down

build: stop
	docker-compose build

ps:
	docker-compose ps

config:
	docker-compose config
