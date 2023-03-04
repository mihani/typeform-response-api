DC = docker compose

##
## Env Dev
##--------
install:
	touch docker/data/history
	cp -n .env .env.local
	$(DC) down --remove-orphans
	$(DC) up --build -d

.PHONY : clean

##
## Quality assurance
## -----------------
phpcs-fixer:
	$(DC) exec php vendor/bin/php-cs-fixer fix --verbose

.PHONY : clean

##
## Env Test
## ---------
install-test:
	cp -n .env.test .env.test.local

phpunit:
	$(DC) exec php bin/phpunit

.PHONY : clean
