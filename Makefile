#!/usr/bin/make -f

ROOT_DIR:=$(shell dirname $(realpath $(lastword $(MAKEFILE_LIST))))

help:
	@echo ""
	@echo "usage: make COMMAND"
	@echo ""
	@echo "Commands:"
	@echo "  app-init                   Install project"
	@echo "  app-run                    Run app"
	@echo "  app-restart                Restart app"
	@echo "  app-stop                   Stop app"
	@echo "  app-cache-clear            Clear app cache"
	@echo "  app-validate               Validate application and security_check"
	@echo "  phpunit-init               Prepare env for testing"
	@echo "  phpunit-run                Start phpunit tests"
	@echo "  database-migrate           Apply app migrations"
	@echo "  database-diff              Show diff in migrations"
	@echo "  database-rollback          Rollback to previous migration version"
	@echo "  database-load              Load fixtures with data purge"
	@echo "  database-dump              Create backup of database"
	@echo "  database-restore           Restore backup from database sql file"
	@echo "  deploy env=dev|stag|prod   Run automated deployment in certain env"

app-init:
	docker-compose up -d app_cli
	docker-compose exec -T app_cli sh -c "/var/www/bin/setup-init.sh"

app-run:
	docker-compose up -d

app-restart:
	docker-compose restart

app-stop:
	docker-compose down -v

app-cache-clear:
	docker-compose up -d app_cli
	docker-compose exec -T app_cli sh -c "bin/console cache:clear"

app-validate:
	docker-compose up -d app_cli
	docker-compose exec -T app_cli sh -c "composer install --prefer-dist --no-scripts --optimize-autoloader && \
		composer validate && \
		bin/console doctrine:schema:validate --skip-sync && \
		vendor/bin/security-checker security:check"

phpunit-init:
	docker-compose up -d app_cli
	docker-compose exec -T app_cli sh -c "bin/setup-test.sh"

phpunit-run:
	docker-compose up -d app_cli
	docker-compose exec -T app_cli sh -c "vendor/bin/simple-phpunit -c phpunit.xml"

database-migrate:
	docker-compose up -d app_cli
	docker-compose exec -T app_cli sh -c "bin/console doctrine:migration:migrate -n"

database-diff:
	docker-compose up -d app_cli
	docker-compose exec -T app_cli sh -c "bin/console doctrine:migration:diff --formatted"

database-rollback:
	docker-compose up -d app_cli
	docker-compose exec -T app_cli sh -c "bin/console doctrine:migration:migrate prev -n"

database-load:
	docker-compose up -d app_cli
	docker-compose exec -T app_cli sh -c "bin/console doctrine:fixtures:load -n"

# @primer make MYSQL_ROOT_USER=root MYSQL_ROOT_PASSWORD=root MYSQL_DATABASE=skeleton4 database-dump
database-dump:
	docker-compose exec -T database sh -c "mysqldump --host=127.0.0.1 -u"$(MYSQL_ROOT_USER)" -p"$(MYSQL_ROOT_PASSWORD)" "$(MYSQL_DATABASE)" > /tmp/dump/"$(MYSQL_DATABASE)".sql"

# @primer make MYSQL_ROOT_USER=root MYSQL_ROOT_PASSWORD=root MYSQL_DATABASE=skeleton4 database-restore
database-restore:
	docker-compose exec -T database sh -c "cat /tmp/dump/"$(MYSQL_DATABASE)".sql | mysql --host=127.0.0.1 -u"$(MYSQL_ROOT_USER)" -p"$(MYSQL_ROOT_PASSWORD)" "$(MYSQL_DATABASE)""

# @primer make deploy env=dev
# @primer make deploy env=stag
# @primer make deploy env=prod
deploy:
	docker run -it --rm -v ${ROOT_DIR}:/var/www:cached -v ~/.ssh:/root/.ssh kolyadin/ruby-rsync:alpine sh -c "cd /var/www && bundle install && bundle exec cap $(env) deploy"