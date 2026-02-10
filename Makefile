PHP_VERSION = 8.4
PHP = /usr/bin/php$(PHP_VERSION)
CP = $(PHP) ~/bin/composer.phar

install:
	$(CP) install
.PHONY: install

update:
	$(CP) update
.PHONY: update

clean:
	rm -f composer.lock
	rm -rf vendor/
.PHONY: clean

all: clean install
.PHONY: all

php-stan:
	$(PHP) vendor/bin/phpstan analyse 2>&1 | tee phpstan.log
.PHONY: php-stan

php-stan-ci:
	$(PHP) vendor/bin/phpstan analyse -c phpstan.neon
.PHONY: php-stan-ci

test:
	$(PHP) vendor/bin/phpunit
.PHONY: test
