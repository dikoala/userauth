<h2>User authentication using Laravel Sanctum</h2>

1) Clone the repository with git clone

2) Copy .env.example file to .env and edit database credentials there

3) cd master

4) Run composer install

5) Run composer update

6) Run php artisan key:generate

7) Run php artisan migrate

8) Run php artisan storage:link (to create a symlink for uploaded avatars)

9) Run php artisan serve (To run as server api)

10) These are the APIs

11) http://localhost:8000/api/register

12) http://localhost:8000/api/login

13) http://localhost:8000/api/confirm (To confirm registration with a PIN)

14) http://localhost:8000/api/update

15) http://localhost:8000/api/logout

16) Postman collection to test the process using the above APIs

    - https://www.dropbox.com/s/0tgx7ya7twbz0zx/UserAuth.postman_collection.json?dl=0

Notes:
Both /update and /logout APIs need a bearer token to work. Bearer token is generated upon /login.
