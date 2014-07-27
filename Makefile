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
	php cli/config.php create
	php cli/migration.php migrations:migrate --no-interaction

install-dev:
	composer self-update
	composer install --no-progress
	mkdir storage
	mkdir cache
	touch storage/ot.db
	php cli/config.php create develop
	php cli/migration.php migrations:migrate develop
	php cli/config.php create-dummy-map develop

install-production:
	composer self-update
	composer install --no-progress
	php cli/config.php create production
	php cli/migration.php migrations:migrate --no-interaction production

run:
	php -S localhost:80 -t web web/index.php
