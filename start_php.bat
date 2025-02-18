@echo off
XAMPDIR=xampp8.2
setlocal enabledelayedexpansion

:: Set project directory (Change this if needed)
set PROJECT_DIR=C:\%XAMPDIR%\htdocs
set PORT=8000

:: Get local IP address
for /f "tokens=2 delims=:" %%a in ('ipconfig ^| findstr "IPv4 Address"') do (
    set IP=%%a
    set IP=!IP:~1!
)

:: Echo the IP
echo Starting PHP service on http://!IP!:%PORT%

:: Check if XAMPP Apache is installed and start it
if exist "C:\%XAMPDIR%\xampp-control.exe" (
    echo Starting Apache...
    start "" "C:\%XAMPDIR%\xampp_start.exe"
    exit
)

:: Start PHP built-in server
cd %PROJECT_DIR%
start /B php -S !IP!:%PORT%
echo PHP built-in server running on http://!IP!:%PORT%
