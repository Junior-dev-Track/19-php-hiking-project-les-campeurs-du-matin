# Foreword

Here are the files from the **previous tutorial** we gave at BeCode.

You can look into PDO and MySQL requests on the Internet. Some recommended resources are :
* [PHPTheRightWay](https://phptherightway.com/#databases)
* [Laracasts PHP for Beginners](https://laracasts.com/series/php-for-beginners-2023-edition/episodes/17)
* [PHP Delusions](https://phpdelusions.net/pdo)


## PDO & MySQL requests

You need to use the `classicmodels` database to run the queries.

`connexion.php` : the connexion to the DB file using PDO and.

`index.php` : where we display all the datas from products table. 

`product.php` : where we display one product from its productCode.  

## Form, user subscription & login

`subscription.php` : an example of form for a user subscription.
- use _$_POST_ superglobal
- validate email with filter
- hash password with bcrypt
- prepare, bind datas & execute the request. 
- redirection to the homepage with `header()`;

`login.php` : login to the website for the user.
- check the password with `password_verify()` 
- create a _$_SESSION_ for the user

`logout.php` : logout to the website for the user.
- delete the _$_SESSION["user"]_ with `unset()`
