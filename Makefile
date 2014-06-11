full-test:
	bin/phpunit tests/
	bin/behat -f progress --no-snippets
	bin/behat -p silex -f progress --no-snippets

full-test-windows:
	bin/phpunit.bat tests/
	bin/behat.bat -f progress --no-snippets
	bin/behat.bat -p silex -f progress --no-snippets

install-test:
	composer self-update
	composer install --no-progress
	mkdir storage
	mkdir cache
	touch storage/ot.db
	chmod a=rwx -R cli/ config/
	cli/config.php create
	cli/migration.php migrations:migrate --no-interaction

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

