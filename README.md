#Mars Rover Project

###API Documentation
Postman collections added into the postman_collection directory. Also if you want the full documentation and examples, please check this [link](https://documenter.getpostman.com/view/911562/UVJbJdvy).
###Installation
```shell
docker-compose -f docker/docker-compose.yml up -d  --build
docker exec -ti mr_php sh -c "composer update"
```
or
```shell
chmod +x install.sh
./install.sh
```
Nginx is configured for http://localhost:8081 or http://marsrover.net:8081. If you want to add domain on your /etc/hosts add the line below to your hosts.
```shell
127.0.0.1 marsrover.net
```

###Tests
Integration tests are used for controller actions.
Unit tests are used for entities or libraries.

To run the tests and saw the test results run the command below.
```shell
docker exec -ti mr_php sh -c "./vendor/bin/phpunit --testdox tests"
```
###Routing
Routing is controlled on service/routes/routes.php file.

If you want to add new route you have to configure it in this file like below.
```injectablephp
Router::add('get', '/v2/plateau', 'App\Controllers\V2\PlateauController::get');
```
###Endpoint Versioning
For API versioning you have to set new route with prefix.
```injectablephp
Router::add('get', '/v2/plateau', 'App\Controllers\V2\PlateauController::get');
```
Sample route is added to routes.php file for an example to this caption. It returns the same plateau response and additional field with name "version";
```json
{
    "error": false,
    "data": {
        "id": 1,
        "upper_bound_x": 5,
        "upper_bound_y": 5,
        "version": "v2"
    }
}
```