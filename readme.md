#OpenTribes
[![Build Status](https://travis-ci.org/Opentribes/Core.png?branch=develop)](https://travis-ci.org/Opentribes/Core)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/00a44706-0e89-488a-98c8-aaad7e12eeca/mini.png)](https://insight.sensiolabs.com/projects/00a44706-0e89-488a-98c8-aaad7e12eeca)

An OpenSource browserbased Game, written in PHP tested with Behat/Mink using Silex

This Project is used to practise [Behavior Driven Development](http://de.wikipedia.org/wiki/Behavior_Driven_Development) and [Clean Code Achitecture](http://blog.8thlight.com/uncle-bob/2012/08/13/the-clean-architecture.html)

The Game is licenced under MIT 

Current [TODO](https://github.com/Opentribes/Core/issues?direction=asc&labels=TODO&milestone=1&page=1&sort=created&state=open)

##[Api Documentation](http://opentribes.github.io/API/)

##[Demo Site](http://ot.blackscorp.de/)

##installation

- clone repository

`git clone -b develop https://github.com/Opentribes/Core.git /path/to/your/folder`

- update dependencies

`cd /path/to/your/folder`

`composer update`

- create configuration

`cli/index.php create-configuration develop`

- edit files in config/develop

- install database

`cli/index.php install-shema develop`

- start server

`php -S localhost:8080 -t web`

- run interactor tests

`bin/behat`

- run silex tests

`bin/behat -p silex`

##shortcuts

- installation

`make install`

- test

`make full-test`
