test:
	bin/behat -p html

install:
	composer install
	php cli/index.php install

update:
	composer update

