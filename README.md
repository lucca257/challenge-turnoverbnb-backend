## Important

I have done this challage in two branchs

[frontend](https://github.com/lucca257/challenge-turnoverbnb-front) : VueJs

[backend](https://github.com/lucca257/challenge-turnoverbnb-backend) : Laravel


this project was all deployed to be tested online, so if you guys would like to see more about the project feel conformable to access the [website](https://challenge-turnoverbnb-front.vercel.app/)

## Developed in:
[Laravel](https://laravel.com/docs/9.x) (9)

## Requirements:
1. [PHP](https://www.php.net/) (8.1)
2. [MySQL](https://www.mysql.com) (8)
3. [Composer](https://getcomposer.org/) (2.1)

### Instructions for installing the project:

this project is dockerized, to start the project just run the command below with docker:
```sh
docker-compose up
```

this challenge was developed in TDD, so if you like to see all the tests you can run this command:
```bash
docker exec -it backend sh -c "php artisan test"
```

### What i have done ?

authentication
- [x] register user
- [x] login user
- [x] logout user
- [x] middleware to check user token
- [x] middleware to check user role

customer
- [x] list all transactions by user and date
- [x] list all deposits by user and date
- [x] create deposit
- [x] list all purchases by user and date
- [x] create purchase
- [x] route to show user image

admin
- [x] list all pending deposits
- [x] details of user deposit 
- [x] review user deposit
- [x] route to show image

# notes

By default, Laravel implements the MVC architecture. I implemented DDD architecture following solid principles architecture, using actions, repositories, and dependency injection.
