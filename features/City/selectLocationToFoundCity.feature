@SelectLocation
Feature: Select location for new city
  In Order to create a city
  as registered user
  you have to specify the direction


  Background:
    Given following tiles:
      | name    | accessable |
      | Grass   | yes        |
      | Forrest |            |
      | Sea     |            |
      | Hill    |            |
    And a map "default" with following tiles:
      | y/x | 1     | 2       | 3     | 4     | 5     | 6     | 7     | 8     |
      | 1   | Grass | Grass   | Grass | Grass | Grass | Grass | Grass | Grass |
      | 2   | Grass | Forrest | Grass | Grass | Grass | Grass | Grass | Grass |
      | 3   | Grass | Grass   | Grass | Grass | Grass | Grass | Grass | Grass |
      | 4   | Grass | Sea     | Grass | Grass | Grass | Grass | Grass | Grass |
      | 5   | Grass | Grass   | Grass | Grass | Grass | Grass | Grass | Grass |
      | 6   | Grass | Grass   | Grass | Grass | Grass | Grass | Grass | Grass |
      | 7   | Grass | Grass   | Grass | Grass | Grass | Grass | Grass | Grass |
      | 8   | Grass | Grass   | Grass | Grass | Grass | Grass | Grass | Grass |
    And following users:
      | username   | password | email          |
      | BlackScorp | 123456   | test@test.de   |
      | Owner1     | 123456   | owner1@test.de |
      | Owner2     | 123456   | owner2@test.de |
    And following cities:
      | name  | owner  | posY | posX |
      | City1 | Owner1 | 3    | 3    |


  Scenario Outline: Specify direction
    Given I'm logged in as user "BlackScorp"
    And I'am on site "game/start"
    When I select location "<location>"
    Then I should be redirected to "/game/city/list"
    And I should have a city in following area:
      | minX   | maxX   | minY   | maxY   |
      | <minX> | <maxX> | <minY> | <maxY> |
    But not at following locations:
      | posY | posX |
      | 3    | 3    |
      | 1    | 1    |
      | 3    | 1    |


  Examples:
    | location | minX | maxX | minY | maxY |
    | north    | 1    | 4    | 1    | 4    |
    | east     | 4    | 8    | 1    | 4    |
    | south    | 4    | 8    | 4    | 8    |
    | west     | 1    | 4    | 4    | 8    |
    | any      | 1    | 8    | 1    | 8    |

