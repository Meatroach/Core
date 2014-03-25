full-test:
	bin/behat -f progress
	bin/behat -p silex -f progress
	bin/phpunit tests/

install-test:
	composer self-update
	composer install --no-progress
	mkdir storage
	touch storage/ot.db
	php cli/index.php install-shema
	php cli/index.php install-roles

install-dev:
	composer self-update
	composer install --no-progress
	mkdir storage
	touch storage/ot.db
	php cli/index.php install-shema develop
	php cli/index.php install-roles develop

install-production:
	composer self-update
	composer install --no-progress
	php cli/index.php install-shema production
	php cli/index.php install-roles production
update:
	composer update
	php cli/index.php install-shema

