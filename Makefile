.PHONY: up down restart seed logs

up:
	docker-compose up -d --build

down:
	docker-compose down

restart:
	docker-compose restart php nginx

seed:
	docker-compose exec php php seed.php

logs:
	docker-compose logs -f
