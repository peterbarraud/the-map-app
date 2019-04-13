ECHO off

set username=gapeterb1
set password=pokerj07
set database=themapapp

mariadb.min\bin\mysql -u %username% -p%password% -D %database%