docker-compose -f docker/docker-compose.yml down -v
docker-compose -f docker/docker-compose.yml up -d --build
docker exec -ti mr_php sh -c "composer update"