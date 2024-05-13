Basic CRUD app with PHP and Mysql

Public folder need to be document root for web server (virtual host). This way other folders not publicly accessible. Php can access config/database.php file with database credentials and make database connection, but web server can not

Create new Mysql (MariaDB) database with name 'paragraf' (user: root, no password)
and create from file is in project root folder name: db.sql
File config/database.php contain database credentials if need to be changed

App content
-   Displaying all data in data table in server pagination mode, using ajax loading
-   Show single resource
-   Edit resource
-   Delete resource
