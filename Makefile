test:
	bin/behat -p html

install:
	composer install
	mkdir storage
	touch storage/ot.db
	php cli/index.php install-shema
	php cli/index.php install-roles

update:
	composer update
	php cli/index.php install-shema

