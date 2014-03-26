full-test:
	bin/behat -f progress --no-snippets
	bin/behat -p silex -f progress --no-snippets
	bin/phpunit tests/

install-test:
	composer self-update
	composer install --no-progress
	mkdir storage
	touch storage/ot.db
	cli/index.php create-configuration
	cli/index.php install-shema
	cli/index.php install-roles

install-dev:
	composer self-update
	composer install --no-progress
	mkdir storage
	touch storage/ot.db
	cli/index.php create-configuration develop
	cli/index.php install-shema develop
	cli/index.php install-roles develop

install-production:
	composer self-update
	composer install --no-progress
	cli/index.php create-configuration production
	cli/index.php install-shema production
	cli/index.php install-roles production
update:
	composer update
	php cli/index.php install-shema
