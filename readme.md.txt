1. Clone this repo: `https://github.com/peterbarraud/the-map-app.git`
2. cd into `<project folder>/the.dr.nefario.backside/`
3. Clone `https://github.com/peterbarraud/the.dr.nefario.backside.git`
4. Move the following folders into the project folder from `Step 2`
`mariadb.min`
`php.min`
5. Double-click `start.db.bat`
6. Double-click `login.root.bat`
7. Run:
```create database themapapp;```
8. Run:
```create user 'gapeterb1'@'localhost' identified by 'pokerj07';```
9. Run:
```grant all privileges on themapapp.* to 'gapeterb1'@'localhost';```
10. Exit MySQL
11. Open the command Window in the `<project folder>/the.dr.nefario.backside/` folder
12. Run:
```login.user.bat gapeterb1 pokerj07 themapapp```
13. Exit MySQL
14. Double-click `push-data-to-mappapp.bat`
15. Run:
```start.php.bat```
16. cd into `<project folder>/the-web-app/`
17. Run:
```npm i```
18. Run:
```npm start```
Get started 

