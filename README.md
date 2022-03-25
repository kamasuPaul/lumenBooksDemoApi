# Lumen Books Demo API
This is a demo application for a abooks api using lumen.

## Documentation
### Application endpoints
* [GET /books](#) - get books
* [GET /books/{bookId}}/characters](#) - get characters in abook
* [GET /books/{bookId}/comments](#) - get comments on abook
* [POST /books/{bookId}/comments](#) - create a comment on abook

Open api documentation for the endpoints can be found [Here:Open api docs](https://kamasupaul.stoplight.io/docs/lumenbooksdemoapi/YXBpOjY4Njc2-books-demo-api).
Postman documentation can be found [Here:Postman docs](https://documenter.getpostman.com/view/16446235/UVsTqMoM).

## installation Steps
The app can easily be deployed using docker to any cloud service that supports docker.
from the docker file in the root of the repository
### manual localhost installation
1. clone the repo
2. run `composer install`
4. Migrate the database
    run `php artisan migrate`
5. Run tests
    run `vendor/bin/phpunit`  
5. Seed the database:  `php artisan db:seed`
6. Start the local php server : `php -S localhost:8000 -t ./public`
6. open http://localhost:8000/books


## Data structures
The application has mainly four models:
1. Book
2. Author
3. Comment
3. Character

### Book
The book model has the following fields:
- id: the primary key
- name: the title of the book
- isbn: the isbn of the book
- publisher: the books publisher
- country: the books country
- release_date: the date of the book release
- number_of_pages: the number of pages in the book

It has a one to many relationship with `Author`.
### Author
The author model has the following fields:
- id: the primary key
- name: the name of the author

It has a one to one relationship with `Book`.
### Comment
The comment model has the following fields:
- body: The comment text
- ip_address: Ip address of the commenter
- book_id: The id of the book the comment is for

It has a one to one relationship with `Book`.
### Character
The character model has the following fields:
-id: the primary key
- name - name of the character
- gender - gender of the character
- culture - the culture the character belongs to
- aliases - other names of the character
- born - date of birth of the character
- died - the date the character died


It has a one to many relationship with `Book`.
## Live Demo



## License
The Lumen framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
