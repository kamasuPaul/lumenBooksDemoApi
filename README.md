# Lumen Books Demo API
This is a demo application for a abooks api using lumen.

## Documentation
Open api documentation can be found [Here:Open api docs](https://kamasupaul.stoplight.io/docs/lumenbooksdemoapi/YXBpOjY4Njc2-books-demo-api).
Postman documentation can be found [Here:Postman docs](https://documenter.getpostman.com/view/16446235/UVsTqMoM).

## installation Steps
The app can easily be deployed using docker to any cloud service that supports docker.
from the docker file in the root of the repository
### manual localhost installation
1. clone the repo
2. run `composer install`
4. Migrate the database
    run `php artisan migrate`
5. Seed the database:  `php artisan db:seed`
6. Start the local php server : `php -S localhost:8000 -t ./public`
6. open http://localhost:8000/books


## Live Demo



## License
The Lumen framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
