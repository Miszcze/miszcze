CALL :AUTORUN
cls
CALL :MACHINA
timeout /t 3 >nul
cls
CALL :MENU
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
rem Wlacz wylacz echo
	ECHO OFF
rem Ustaw kolor
	COLOR 3F
rem Wersja programu MACHINA
	SET v=1.0
rem Nazwa Gita
	SET GIT=MISZCZE
rem Ścieżka do apatcha
	SET SCIEZKA=C:\xampp\htdocs\%GIT%
rem sciezkla do chroma
	SET CHROME="C:\Program Files (x86)\Google\Chrome\Application\chrome.exe"
rem sciezka do Internet Explorera
	SET IE="C:\Program Files (x86)\Internet Explorer\iexplore.exe"
rem sciezka do Firefoxa
	SET FIREFOX="Wpisac tutaj sciezke do programu firefox"
rem Wybrana przegladarka
	SET PRZEGLADARKA=%CHROME%
rem Adres aplikacji
	SET ADRES=127.0.0.1
	SET PORT=8000
EXIT /B
rem ==========================================
:MACHINA
	ECHO.
	ECHO.
	ECHO.
	ECHO.
	ECHO      =======================
	ECHO      =                     =
	ECHO      = M A C H I N A v.%v% =
	ECHO      =                     =
	ECHO      =======================
	ECHO.
	ECHO.
	ECHO.
EXIT /B
rem ==========================================
:MENU
	ECHO.
	ECHO.
	ECHO.
	ECHO     Witaj %USERNAME% 
	ECHO   Co chcesz zrobic?
	ECHO.
	ECHO 1) Uruchomic server
	ECHO 2) Uruchomic aplikacje 
	ECHO 2) Wyslij na %GIT%
	ECHO 3) Pobierz z %GIT%
	ECHO 4) USTAWIENIA
	ECHO 5) Koniec
	ECHO.
	SET /P MENU=Wybor=
	if %MENU%==1 (
		CALL :serverRun
		cls
		GOTO :MENU
	) else (
		IF %MENU%==2 (
			CALL :appRun
			cls
			GOTO :MENU
		) else (
			IF %MENU%==3 (
				CALL :Wyslij
				cls
				GOTO :MENU
			) else (
				IF %MENU%==4 (
					ECHO 4
					cls
					GOTO :MENU
				) else (
					IF %MENU%==5 (
						ECHO 5
						GOTO :KONIEC
					) else (
						ECHO.
						ECHO.
						ECHO Nieprawidlowy wybor - %MENU%
						ECHO Sproboj ponownie
						timeout /t 3 >nul
						cls
						GOTO :MENU 
					)
				)
			)
		)
	)
EXIT /B
rem ==========================================
:serverRun
	cls
	ECHO.
	ECHO.
	ECHO.
	ECHO Uruchamiam . . .
	START /MIN /D %SCIEZKA% php bin/console server:run
	IF %ERRORLEVEL%==0 ( ECHO Odpalone . . .
	) ELSE ( ECHO Cos poszlo nie tak)
	timeout /t 3 >nul
EXIT /B
rem ==========================================
:appRun
	cls
	ECHO.
	ECHO.
	ECHO.
	ECHO Uruchamiam aplikacje . . .
	%PRZEGLADARKA% %ADRES%:%PORT%
	IF %ERRORLEVEL%==0 ( ECHO Odpalone . . .
	) ELSE ( ECHO Cos poszlo nie tak)
	timeout /t 3 >nul
EXIT /B
rem ==========================================
:Wyslij
	cls
	ECHO.
	ECHO.
	ECHO CTRL+C - Anuluj
	SET /P ADD=Wprowadz parametr GIT add 
	CD %SCIEZKA%
	cls
	ECHO.
	ECHO.
	ECHO ===============================
	ECHO Wykonuje GIT add %ADD%
	ECHO.
	GIT add %ADD%
	ECHO.
	ECHO Dodano
	ECHO ===============================
	ECHO Wykonuje GIT commit -m %GIT%
	ECHO.
	GIT commit -m %GIT%
	ECHO.
	ECHO Zakomintowano
	ECHO ===============================
	ECHO Wykonuje GIT push
	ECHO.
	GIT push
	ECHO.
	ECHO Wyslano
	ECHO ===============================
	ECHO.
	ECHO Wcisnij klawisz aby wrocic do menu
	Pause >nul
EXIT /B
rem ==========================================
:KONIEC
	ECHO KONIEC
	ECHO Wcisnij klawisz aby zakonczyc
	pause >nul
rem ==========================================