full-test:
	bin/phpunit tests/
	bin/behat -f progress --no-snippets
	bin/behat -p silex -f progress --no-snippets

install-test:
	composer self-update
	composer install --no-progress
	mkdir storage
	mkdir cache
	touch storage/ot.db
	cli/config.php create
	cli/migration.php migrations:migrate --no-interaction
	cli/config.php create-dummy-map

install-dev:
	composer self-update
	composer install --no-progress
	mkdir storage
	mkdir cache
	touch storage/ot.db
	cli/config.php create develop
	cli/migration.php migrations:migrate develop
	cli/config.php create-dummy-map develop

install-production:
	composer self-update
	composer install --no-progress
	cli/config.php create production
	cli/migration.php migrations:migrate --no-interaction production

