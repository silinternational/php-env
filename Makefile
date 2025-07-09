test:
	docker compose run --rm test composer install
	docker compose run --rm test ./vendor/bin/phpunit --process-isolation tests/

testhost:
	composer install --ignore-platform-reqs
	bash -c "vendor/bin/phpunit --process-isolation tests/"
