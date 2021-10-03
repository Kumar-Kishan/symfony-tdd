# Setup Instructions

First get a marvel developer's api key from https://developer.marvel.com/ and place it in .env file as needed here

    ### Get these from https://developer.marvel.com/
    MARVEL_PUBLIC_KEY=
    MARVEL_PRIVATE_KEY=
    ### Replace the connection string
    DATABASE_URL=

Run the following commands after that to create necessary tables and database, also

    php bin/console doctrine:migrations:migrate
    php bin/console doctrine:fixtures:load  //Seeds with a default use with token
    php bin/console app:sync-heroes   //Calls Marvel API and loads into the database

Now you can run the tests

    ###Integration Tests
    symfony php bin/phpunit .\tests\integration
    ###Feature Tests
    symfony php bin/phpunit .\tests\feature
    ###Functional Tests
    symfony php bin/phpunit .\tests\controller

Test logs can be found at ./var/log/test.log
