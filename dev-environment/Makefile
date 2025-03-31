up:
	docker-compose -f docker-compose.yml up -d --build

down:
	docker-compose -f docker-compose.yml down

restart:
	make down && make up

shell:
	docker-compose exec php bash

composer:
	docker-compose exec php composer $(cmd)

console:
	docker-compose exec php php bin/console $(c)