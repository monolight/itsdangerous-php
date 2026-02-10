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
	clear
	-$(PHP) vendor/bin/phpstan analyse > phpstan.log
	$(PHP) vendor/bin/phpstan analyse
.PHONY: php-stan

php-stan-ci:
	$(PHP) vendor/bin/phpstan analyse -c phpstan.neon
.PHONY: php-stan-ci

rector-dry-run:
	$(PHP) vendor/bin/rector process --dry-run
.PHONY: rector-dry-run

rector-run:
	$(PHP) vendor/bin/rector process
.PHONY: rector-run
