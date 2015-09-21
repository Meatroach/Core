#OpenTribes
[![Build Status](https://travis-ci.org/Opentribes/Core.png?branch=develop)](https://travis-ci.org/Opentribes/Core)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/00a44706-0e89-488a-98c8-aaad7e12eeca/mini.png)](https://insight.sensiolabs.com/projects/00a44706-0e89-488a-98c8-aaad7e12eeca)
[![Gitter chat](https://badges.gitter.im/Opentribes/Core.png)](https://gitter.im/Opentribes/Core)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/Opentribes/Core/badges/quality-score.png?b=develop)](https://scrutinizer-ci.com/g/Opentribes/Core/?branch=develop)
[![Code Coverage](https://scrutinizer-ci.com/g/Opentribes/Core/badges/coverage.png?b=develop)](https://scrutinizer-ci.com/g/Opentribes/Core/?branch=develop)

An OpenSource browser based Game, written in PHP

the goal of this Project is to provide a high quality OpenSource strategy browser game. 
Therefore we try to aim high code coverage and apply Clean Code Architecture.

The content of the src folder is Framework independent this allows us to switch the Framework to a better one in the future.
The src folder will be moved after development to its own repository while this repository will be the implementation to a Framework.

The Game is licenced under MIT 


##Installation

- comming soon

##Vagrant

There's a simple vagrant environment made for this project.
You simply have to run __vagrant up__ in the root directory and the machine is ready and all composer dependencies were installed.

You access via __vagrant ssh__ the VM. The project is mounted to __/var/www/opentribes__.
In this directory you can run all console commands.

This commands auto-configures the test and dev environment, so you don't have to adjust new database configuration parameters.

The web interface has the ip __192.156.68.112__ and must be opened using the host __opentribes.dev__, so you should add the following entry to your __/etc/hosts__ file:

    192.168.57.333 opentribes.dev

This file can be found on windows at: __C:\Windows\System32\drivers\etc__.
