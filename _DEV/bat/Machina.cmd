CALL :AUTORUN
CALL :MACHINA
CALL :MENU

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
	CLS
	CALL :ECHA 3
	ECHO      =======================
	ECHO      =                     =
	ECHO      = M A C H I N A v.%v% =
	ECHO      =                     =
	ECHO      =======================
	timeout /t 1 >nul
	CALL :ECHA 3
	ECHO UWAGA !!! UWAGA !!! UWAGA
	ECHO Parametry pracy aplikacji:
	ECHO.
	ECHO SCIEZKA=%SCIEZKA%
	ECHO PRZEGLADARKA=%PRZEGLADARKA%
	ECHO ADRES APKI=%ADRES%:%PORT%
	ECHO GIT=%GIT%
	ECHO.
	ECHO W razie potrzeby zmien
	timeout /t 10 >nul
EXIT /B
rem ==========================================
:MENU
	cls
	CALL :ECHA 5
	ECHO     Witaj %USERNAME% 
	ECHO   Co chcesz zrobic?
	ECHO.
	ECHO 1) Uruchomic server php
	ECHO 2) Uruchomic aplikacje 
	ECHO 3) Wyslij na %GIT%
	ECHO 4) Pobierz z %GIT%
	ECHO 5) USTAWIENIA
	ECHO 6) Koniec
	ECHO.
	SET /P MENU=Wybor=
	if %MENU%==1 (
		CALL :serverRun
		GOTO :MENU
	) else (
		IF %MENU%==2 (
			CALL :appRun
			GOTO :MENU
		) else (
			IF %MENU%==3 (
				CALL :Wyslij
				GOTO :MENU
			) else (
				IF %MENU%==4 (
					CALL :Pobierz
					GOTO :MENU
				) else (
					IF %MENU%==5 (
						CALL :USTAWIENIA
						GOTO :MENU
					) else (
						IF %MENU%==6 (
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
	)
EXIT /B
rem ==========================================
:serverRun
	cls
	CALL :ECHA 5
	ECHO Uruchamiam . . .
	START /MIN /D %SCIEZKA% php bin/console server:run
	IF %ERRORLEVEL%==0 ( ECHO Odpalone . . .
	) ELSE ( ECHO Cos poszlo nie tak)
	timeout /t 3 >nul
EXIT /B
rem ==========================================
:appRun
	cls
	CALL :ECHA 5
	ECHO Uruchamiam aplikacje . . .
	%PRZEGLADARKA% %ADRES%:%PORT%
	IF %ERRORLEVEL%==0 ( ECHO Odpalone . . .
	) ELSE ( ECHO Cos poszlo nie tak)
   	timeout /t 3 >nul
EXIT /B
rem ==========================================
:Wyslij
	cls
	CALL :ECHA 5
	ECHO CTRL+C - Anuluj
	SET /P ADD=Wprowadz parametr GIT add 
	CD %SCIEZKA%
	cls
	CALL :ECHA 5
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
	timeout /t 3 >nul
	ECHO Wcisnij klawisz aby wrocic do menu
	Pause >nul
EXIT /B
rem ==========================================
:Pobierz
	CD %SCIEZKA%
	cls
	CALL :ECHA 5
	ECHO ===============================
	ECHO Wykonuje GIT PULL
	ECHO.
	GIT pull
	ECHO.
	ECHO Pobrano
	ECHO ===============================
	ECHO.
	timeout /t 3 >nul
	ECHO Wcisnij klawisz aby wrocic do menu
	Pause >nul
EXIT /B
rem ==========================================
:USTAWIENIA
	cls
	ECHO.
	ECHO. NARAZIE NIE JEST GOTOWE
	FOR /L %%A IN (0,1,9) DO (
		FOR /L %%B IN (0,1,9) DO (
			COLOR %%A%%B
			timeout /t 1 >nul
			COLOR %%B%%A
			timeout /t 1 >nul
		)
	)
	color 3f
EXIT /B
rem ==========================================
:ECHA
	FOR /L %%A IN (1,1,%1) DO (
	ECHO.
	)
EXIT /B
rem ==========================================
:KONIEC
	cls
	ECHO.
	ECHO KONIEC
	ECHO Wcisnij klawisz aby zakonczyc
	pause >nul
rem ==========================================