full-test:
	bin/behat -f progress
	bin/behat -p silex -f progress

install:
	composer install --no-progress
	mkdir storage
	touch storage/ot.db
	php cli/index.php install-shema
	php cli/index.php install-roles

update:
	composer update
	php cli/index.php install-shema

