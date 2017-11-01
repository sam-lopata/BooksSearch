# BookSearch

A Symfony example project.

Simple books listing and search application using Symfony 3, Doctrine ORM 2,  Twitter Bootstrap 3, PHPUnit tests.


# Requirements 

- PHP 7.1 (mysql_pdo, xml, curl, zip, mbstring)
- MySql server
- NodeJs
- Nmp
- Less
- Composer


# Installation notes

- Clone the repository
	```sh
	git clone https://github.com/sam-lopata/BooksSearch.git
	```

- Get dependencies
	```sh
	composer update
	```

- Fullfill parameters.yml
	```sh
	/app/config/parameters.yml
	```

- Create Mysql user with right to prod, dev and test DBs
- Execute 
	```sh
	bin/console doctrine:schema:create
	bin/console doctrine:fixtures:load
	bin/console assetic:dump
	```

- Runnung tests
	```sh
	./vendor/bin/simple-phpunit
	```
