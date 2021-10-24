<h2>User authentication using Laravel Sanctum</h2>

1) Clone the repository with git clone

2) Copy .env.example file to .env and edit database credentials there

3) cd userauth

4) git checkout master

5) Run composer install

6) Run composer update

7) Run php artisan key:generate

8) Run php artisan migrate

9) Run php artisan storage:link (to create a symlink for uploaded avatars)

11) Run php artisan serve (To run as server api)

12) These are the APIs

13) http://localhost:8000/api/register

14) http://localhost:8000/api/login

15) http://localhost:8000/api/confirm (To confirm registration with a PIN)

16) http://localhost:8000/api/update

17) http://localhost:8000/api/logout

18) Postman collection to test the process using the above APIs

    - https://www.dropbox.com/s/0tgx7ya7twbz0zx/UserAuth.postman_collection.json?dl=0

Notes:
Both /update and /logout APIs need a bearer token to work. Bearer token is generated upon /login.
