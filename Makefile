tester = vendor/bin/tester
tests_dir = tests/
coverage_name = coverage.html
php_ini = $(tests_dir)php-unix.ini
php_bin = php

.PHONY: test coverage clean phpstan
test:
		@$(tester) -p $(php_bin) -c $(php_ini) $(tests_dir)

coverage:
		@$(tester) -p $(php_bin) -c $(php_ini) --coverage $(coverage_name) --coverage-src src/ $(tests_dir)

clean:
		@rm -f $(coverage_name)

phpstan:
		phpstan analyse --configuration tests/phpstan.neon
