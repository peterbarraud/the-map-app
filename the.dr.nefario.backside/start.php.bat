ECHO off

SET phpport=8089
SET startdir=.
SET phpdir=php.min

ECHO Running PHP on PORT %phpport%

%phpdir%\php -S localhost:%phpport% -t %startdir% -c %phpdir%\php.ini || (
	pause
)
