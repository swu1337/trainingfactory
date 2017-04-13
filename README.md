# Training Factory Den Haag
Schoolproject K2

# Setup Project

Requirements: 
- [WAMP](http://www.wampserver.com/en/) or [XAMP](https://www.apachefriends.org/index.html)
- [GIT](https://git-scm.com/)
- Any IDE (Prefer Netbeans or JetBrains Products)
Clone the project

- Navigate to your wamp or xampp folder

``C:\wamp64\www``
``C:\xampp\htdocs\``

- Open your command line and execute the following for cloning from the repository:

``git clone https://github.com/swu1337/trainingfactory.git``

# Import database

- Open your browser go to your [localhost](http://localhost/phpmyadmin/) and login
- Go to 'Import' and select in your project directory the sql files
- ``C:\xampp\htdocs or C:\wamp64\www\trainingfactory\database\trainingfactory.sql``
- ``C:\xampp\htdocs or C:\wamp64\www\trainingfactory\database\trainingfactory.data.sql``
- Scroll down and click on GO

Database should be imported now

# Development Environment
The webapplication should be runnning on http://localhost/trainingfactory

Don't change the framework files unless you know what you're doing.

Developers should be working and only be working in the dev files for php.


# CSS Structure
We are using bootstrap, try to use bootstrap properties before making new class.

Follow [Bootsrap Documentation](http://getbootstrap.com/css/)

For every new partial make a new css file and remember to include it in the style.css

``@import url(src)``

# Javascript
Use module pattern

Here is an in depth Javascript Module Pattern Example [Click me](http://www.adequatelygood.com/JavaScript-Module-Pattern-In-Depth.html) 


