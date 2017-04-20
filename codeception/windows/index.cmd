#SET TESTS_DIR=%~dp0

SET CurrDir=%CD%
CD..
SET TESTS_DIR=%CD%
CD %CurrDir%

call %TESTS_DIR%\windows\cmd\config.cmd
start %TESTS_DIR%\windows\cmd\start-selenium-server.cmd

Timeout /t 2 >nul

CD..
rem php ./vendor/codeception/codeception/codecept run codeception/acceptance/TestCest.php --colors --steps --html

rem php ./vendor/codeception/codeception/codecept run acceptance some.feature
rem php ./vendor/codeception/codeception/codecept run -g scenarioName --html --debug --colors --steps

pause