PHP := php
CONSOLE := $(PHP) bin/console
THIS_FILE := $(lastword $(MAKEFILE_LIST))

-include .env

install: dev

cs:
	bin/php-cs-fixer fix --verbose

cs-dry-run:
	bin/php-cs-fixer fix --verbose --dry-run

phpstan:
	bin/phpstan analyse

phan:
	bin/phan

phan-strict:
	bin/phan -S

psalm:
	bin/psalm

phpmd:
	bin/phpmd src/ ansi .phpmd.xml

code-analyse:
	$(MAKE) phpstan || true
	$(MAKE) phan || true
	$(MAKE) psalm || true
	$(MAKE) phpmd || true

c-inst:
	composer install

admin:
	$(CONSOLE) admin

default-admin:
	$(CONSOLE) fos:user:create admin admin@admin.com admin --super-admin

test:
	bin/phpunit -c app src --process-isolation

test-failing:
	bin/phpunit -c app src --group failing --process-isolation

dev: c-inst set-permissions cache-dev yarn yarn-build install-assets install-web-assets yarn-encore cache-dev
	$(MAKE) -f $(THIS_FILE) set-permissions

yarn-encore:
	yarn encore dev

prod: c-inst inc-assets-version set-permissions-wo-sudo cache-prod yarn yarn-build install-assets dump yarn-encore
	$(MAKE) -f $(THIS_FILE) set-permissions-wo-sudo

set-permissions:
	sudo $(MAKE) -f $(THIS_FILE) set-permissions-wo-sudo

rm-cache:
	sudo rm -rf var/cache/de* && sudo rm -rf var/cache/prod

clear-cache-dev: set-permissions cache-dev
	$(MAKE) -f $(THIS_FILE) set-permissions

clear-cache-prod: set-permissions cache-prod
	$(MAKE) -f $(THIS_FILE) set-permissions

cache-dev:
	$(CONSOLE) cache:clear --env=dev

cache-prod:
	$(CONSOLE) cache:clear --env=prod

update-db:
	$(CONSOLE) doctrine:schema:update --force --dump-sql

reload-db:
	$(CONSOLE) doctrine:database:drop --force
	$(MAKE) -f $(THIS_FILE) create-db

create-db:
	$(CONSOLE) doctrine:database:create

create-schema:
	$(CONSOLE) doctrine:schema:create

reload-db-test:
	$(CONSOLE) doctrine:database:drop --force --env=test
	$(CONSOLE) doctrine:database:create --env=test
	$(CONSOLE) doctrine:schema:create --env=test

dump:
	composer dump-autoload --optimize

install-assets: install-web-assets
	$(CONSOLE) fos:js-routing:dump --target=public/compiled/js/fos_js_routes.js

yarn:
	yarn

yarn-build:
	yarn run build

install-web-assets:
	$(CONSOLE) assets:install public --symlink

migrate:
	$(CONSOLE) doctrine:migrations:migrate latest

migrate-next:
	$(CONSOLE) doctrine:migrations:migrate next

migrate-prev:
	$(CONSOLE) doctrine:migrations:migrate prev

migrations-diff:
	$(CONSOLE) doctrine:migrations:diff

migrations-status:
	$(CONSOLE) doctrine:migrations:status --show-versions

inc-assets-version:
	ASSETS_NUM=$$(cat .env | grep assets_version: | grep -Eo '[0-9]{1,4}'); \
	sed -i "s/assets_version: $$ASSETS_NUM/assets_version: $$((ASSETS_NUM+1))/" .env

dev-wo-permissions: cache-dev yarn-build install-assets update-class-field-scope-acl
	$(MAKE) -f $(THIS_FILE) rebuild-category-tree

install-dependencies: c-inst yarn

pre-autoprod:
	rm -rf var/cache/de* && rm -rf var/cache/prod
	chmod -R ug+rw .
	chmod -R a+rw var/cache var/log var/spool public/compiled
	cp app/config/parameters.yml.deploy app/config/parameters.yml

autoprod: c-inst yarn cache-prod yarn-build install-assets dump update-class-field-scope-acl
	$(MAKE) rebuild-category-tree

set-permissions-wo-sudo:
	chmod -R ug+rw .
	chmod -R a+rws var/cache var/log

load-fixtures:
	$(CONSOLE) hautelook:fixtures:load

router:
	$(CONSOLE) debug:router
