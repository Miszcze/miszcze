CALL :AUTORUN
cls
CALL :MACHINA



GOTO :KONIEC





rem ==========================================
rem Wysylanie
rem GIT add .
rem GIT commit -m miszcze
rem GIT push
rem ==========================================
rem Pobieranie
rem GIT pull
rem ==========================================
:AUTORUN
ECHO OFF
SET COLOR=3F
SET SCIEZKA=C:\xampp\htdocs\miszcze
rem ==========================================
:MACHINA
ECHO.
ECHO.
ECHO.
ECHO.
ECHO      =======================
ECHO      =                     =
ECHO      = M A C H I N A v.1.0 =
ECHO      =                     =
ECHO      =======================
ECHO.
ECHO.
ECHO.
rem ==========================================
:KONIEC
ECHO Wcisnij klawisz aby zakonczyc
pause >nul
exit
rem ==========================================