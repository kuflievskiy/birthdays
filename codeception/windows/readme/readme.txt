####################
# HOW TO USE : 
####################

1. Install XAMPP, open XAMPP console
2. Run "cd path/to/your/tests"
3. Run "php vendor/codeception/codeception/codecept bootstrap"
   Run "php vendor/codeception/codeception/codecept build"
4. Copy data from tests/acceptance.suite.sample.yml to tests/acceptance.suite.yml, edit
5. Create file cmd/config.cmd, copy data from cmd/config.sample.cmd to cmd/config.cmd
6. Establish tunnel connection with testing database: "L3306 localhost:3306"	
7. Run "index.cmd"

####################
# POSSIBLE ERRORS :
####################

Codeception\Extension\MultiDb: SQLSTATE[HY000] [1045] Access denied for user 'cms'@'localhost' (using password: YES) while creating PDO connection [PDOException] 

# http://stackoverflow.com/questions/6379577/need-to-use-utc-timestamp-conversion-on-in-php-mysql-on-a-per-connection-basis
- mysql_tzinfo_to_sql /usr/share/zoneinfo | mysql -u%MYSQL_USER_NAME% -p'%MYSQL_USER_PASSWORD%' -e 'use db319716_8;'
- SET time_zone =  'UTC';


# [Facebook\WebDriver\Exception\UnknownServerException]
unknown error: cannot get automation extension
from unknown error: page could not be found: chrome-extension://aapnijgdinl
hnhlmodcfapnahmbfebeb/_generated_background_page.html

Update version of chromedriver from https://sites.google.com/a/chromium.org/chromedriver/downloads
