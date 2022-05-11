test: build
	docker-compose run test composer install
	docker-compose run test ./vendor/bin/phpunit --process-isolation tests/

testhost: build
	composer install --ignore-platform-reqs
	bash -c "vendor/bin/phpunit --process-isolation tests/"

build:
	docker-compose build
