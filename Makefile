test:
	docker-compose run test composer install
	docker-compose run test ./vendor/bin/phpunit --process-isolation tests/
	
