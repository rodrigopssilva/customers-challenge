# Customers Challenge

## Getting Started

1. Setup the server. You can use a local Docker container instead of installing stuff in your computer.
   ```
   git clone git@github.com:rodrigopssilva/customers-challenge.git

   cd customers-challenge

   cp .env.example .env

   docker-compose up -d
   ```

   If necessary, you can access the php machine with:
   ```
   docker exec -it customers-api-php-fpm bash
   ```
2. Install the application dependencies. You need to run the command above in order to  create the tables and  populate the database. Just run:
   ```
    docker exec -it customers-api-php-fpm composer install
   ```
3. Set write permission to whole storage directory. Laravel needs to have permission to write files inside directory storage. Run the command bellow:
   ```
    docker exec -it customers-api-php-fpm chmod 777 -R /usr/share/nginx/html/storage
   ```
4. You are ready to go! Now you can enjoy the application API.

5. How to use it:

    First you have to login and store de JWT token. With Postman or insomnia do:
    ```
     POST http://127.0.0.1:8007/api/auth/login
     {
     	"email": "nimda@admin.com",
     	"password": "secret" // secret is the default password
     }
    ```
    The request above will return the JWT token. Store the generated token to the follow requests. Example:
    ```
     Authorization: Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiaWF0IjoxNTE2MjM5MDIyfQ.SflKxwRJSMeKKF2QT4fwpMeJf36POk6yJV_adQssw5c
    ```
    To list your customers run the request bellow:
    ```
     GET http://127.0.0.1:8007/api/customer
    ```
    To view one specific customer run the request bellow:
    ```
     GET http://127.0.0.1:8007/api/customer/1
    ```
    To update one specific customer run the request bellow:
    ```
     PUT http://127.0.0.1:8007/api/customer/1
     {
        "name": "Foo",
        "email": "foo@bar.com",
        "phone": "+99111111111",
        "country_id": 11
      }
    ```
    To add a new customer run the request bellow:
    ```
     POST http://127.0.0.1:8007/api/customer
     {
         "name": "Foo",
         "email": "foo@bar.com",
         "phone": "+99111111111",
         "country_id": 11
     }
    ```
    To delete one specific customer run the request bellow:
    ```
     DELETE http://127.0.0.1:8007/api/customer/1
    ```
6. WARNING: All the requests above will check if the authenticated user can list/view/update/delete customers. If you are the owner you can see the customer's data. Otherwise you will recieve a 401 "You Shall Not Pass!!!"

7. Have fun!
