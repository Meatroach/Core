full-test:
	bin/behat -f progress --no-snippets
	bin/behat -p silex -f progress --no-snippets
	bin/phpunit tests/

install-test:
	composer self-update
	composer install --no-progress
	mkdir storage
	touch storage/ot.db
	cli/config.php create
        cli/migration.php migrations:migrate --no-interaction

install-dev:
	composer self-update
	composer install --no-progress
	mkdir storage
	touch storage/ot.db
	cli/config.php create develop
	cli/migration.php migrations:migrate develop

install-production:
	composer self-update
	composer install --no-progress
	cli/config.php create production
	cli/migration.php migrations:migrate --no-interaction production

