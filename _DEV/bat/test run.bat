@echo off
cd C:\wamp64\www\miszcze
@echo on
./vendor/bin/simple-phpunit
@echo off
echo.
echo kliknij enter aby wylaczyc konsole
SET /P exit=