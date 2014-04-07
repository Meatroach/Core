#OpenTribes
[![Build Status](https://travis-ci.org/Opentribes/Core.png?branch=develop)](https://travis-ci.org/Opentribes/Core)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/00a44706-0e89-488a-98c8-aaad7e12eeca/mini.png)](https://insight.sensiolabs.com/projects/00a44706-0e89-488a-98c8-aaad7e12eeca)
[![Gitter chat](https://badges.gitter.im/Opentribes/Core.png)](https://gitter.im/Opentribes/Core)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/Opentribes/Core/badges/quality-score.png?s=ef00254db3e6d7f4f0ea5007205f690151d2ef03)](https://scrutinizer-ci.com/g/Opentribes/Core/)
[![Code Coverage](https://scrutinizer-ci.com/g/Opentribes/Core/badges/coverage.png?s=ae06a82506ed6ad480ae433aecce370de868e3dd)](https://scrutinizer-ci.com/g/Opentribes/Core/)

An OpenSource browserbased Game, written in PHP tested with Behat/Mink using Silex

This Project is used to practise [Behavior Driven Development](http://de.wikipedia.org/wiki/Behavior_Driven_Development) and [Clean Code Achitecture](http://blog.8thlight.com/uncle-bob/2012/08/13/the-clean-architecture.html)

The Game is licenced under MIT 

Current [TODO](https://github.com/Opentribes/Core/issues?direction=asc&labels=TODO&milestone=1&page=1&sort=created&state=open)

#[Api Documentation](http://opentribes.github.io/API/)

#[Demo Site](http://ot.blackscorp.de/)

#[Current Front-End Tests](http://opentribes.github.io/API/report-silex.html)

#[Current Interactor Tests](http://opentribes.github.io/API/report.html)

#[PHPUnit Testcoverage](http://opentribes.github.io/API/coverage/)

##installation

- clone repository

`git clone -b develop https://github.com/Opentribes/Core.git /path/to/your/folder`

- update dependencies

`cd /path/to/your/folder`

`composer update`

- create configuration

`cli/config.php create develop`

- edit files in config/develop

- install database

`cli/migration.php migrations:migrate develop`

- create dummy map

`cli/config.php create-dummy-map develop`

- start server

`php -S localhost:8080 -t web`

- run interactor tests

`bin/behat`

- run silex tests

`bin/behat -p silex`

##shortcuts

- installation

`make install-dev`

- test

`make full-test`
