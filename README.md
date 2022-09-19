# SpaceGame
A php based Text Game directly in your webbrowser, where you can build a Space Company. 

During Development I want to continuously add a API, so i can later make a android app out of the game, and maybe one day even make it a Desktop App.
The Anroid App and API Development is planned to start during the Development, when the base like Accounting and Profile is done. 

# Requirements
- PHP 8.1 or higher
- PHP Extensions: PDO, OpenSSL, JSON
- MySQL/MariaDB Server
- CLI Access
- pdo-mysql enabled for CLI

# Installation
1. navigate to the project root
2. Import data/SQL/database.sql to your database
3. Copy .env.exampe and rename it to .env
4. Enter your Configuration into the .env File
5. Run `php ./bin/console.php base:install`
6. Run `php ./bin/console.php database:update`

You should now be able to use the API.
