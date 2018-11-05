@echo off
color 02
echo podaj nazwe commita:
SET /P commit=
@echo on
cd C:\wamp64\www\miszcze
git add .
git commit -m "%commit%"
git push
@echo off
echo.
echo kliknij enter aby wylaczyc konsole
SET /P exit=
@echo on