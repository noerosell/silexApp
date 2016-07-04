# silexApp
- This App retrieves from Twitter Rest Api the number of twits desired from a valid user.

######  Instalation
  - Checkout the repository
  `git clone git@github.com:noerosell/silexApp.git` can be a valid statement
  - execute `composer.phar install` in the app root directory
###### Run App
  - In Web directory run command
  `php -S localhost:80` (with sudo if you have not necessary perms)
  - point your browser to 
    `localhost/get/10/tweets/from/@peitocavernoso`

###### Run Unit tests
  - In root directory execute the command
  `./vendor/bin/phpunit --bootstrap ./vendor/autoload.php Test`
  
###### Run Integration tests
  - In root directory execture the command
  `./vendor/bin/behat`
