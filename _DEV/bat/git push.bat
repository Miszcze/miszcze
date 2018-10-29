@echo off
color 0a
echo podaj nazwe commita:
SET /P commit=
@echo on
cd C:\wamp64\www\miszcze
git add .
git commit -m "%commit%"
git push