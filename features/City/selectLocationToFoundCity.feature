@SelectLocation
Feature: Select location for new city
In Order to create a city
as registered user
you have to specify the direction


    Background:
        Given following tiles:
           | name | accessable |
           | Grass | yes |
           | Forrest |  |
           | Sea |  |
           | Hill |  |
        And a map "default" with following tiles:
         |   y/x   |   0   |   1   |   2   |   3   |   4   |
         |  0   | Grass | Grass | Grass | Grass | Grass |
         |  1   | Grass | Forrest | Grass | Grass | Grass |
         |  2   | Grass | Grass | Grass | Grass | Grass |
         |  3   | Grass | Sea | Grass | Grass | Grass |
         |  4   | Grass | Grass | Grass | Grass | Grass |
        And following users:
            | username | password | email |
            | BlackScorp | 123456 | test@test.de |
            | Owner1 | 123456 | owner1@test.de |
            | Owner2 | 123456 | owner2@test.de |
        And following cities:
            | name | owner | x | y |
            | City1 | Owner1 | 0 | 0 |
            | City2 | Owner2 | 2 | 0 |


Scenario Outline: Specify direction
    Given I'm logged in as user "BlackScorp"
    And I'am on site "game/start"
    When I select location "<location>"
    Then I should have a city in following area:
        | minX | maxX | minY | maxY |
        | <minX> | <maxX> | <minY> | <maxY> |
    But not at following locations:
        | y | x |
        | 0 | 0 |
        | 2 | 0 |
        | 1 | 1 |
        | 3 | 1 |


Examples:
    | location | minX | maxX | minY | maxY |
    | north | 0 | 2 | 0 | 2 |
    | east | 2 | 4 | 0 | 2 |
    | west | 2 | 4 | 2 | 4 |
    | south | 0 | 2 | 2 | 4 |
    | any | 0 | 4 | 0 | 4 |

