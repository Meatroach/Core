@CheckCities
Feature: check cities
  In order to select a location for new City,
  as registered player,
  i should not have any cities

  Background:
    Given following users:
      | username   | password | email        |
      | BlackScorp | 123456   | test@test.de |

  Scenario: Redirect to select location page
    Given I'm logged in as user "BlackScorp"
    When I visit "/"
    Then I should be redirected to "/game/start"

  Scenario: No redirects
    Given following cities:
      | name  | owner      | posX | posY | isMain |
      | City1 | BlackScorp | 0    | 0    | true   |
      | City2 | BlackScorp | 0    | 0    | false  |
    And I'm logged in as user "BlackScorp"
    When I visit "/"
    Then I should be redirected to "/game/"

  Scenario: Redirect from new city screen
    Given following cities:
      | name  | owner      | posX | posY | isMain |
      | City1 | BlackScorp | 0    | 0    | true   |
      | City2 | BlackScorp | 0    | 0    | false  |
    And I'm logged in as user "BlackScorp"
    When I visit "/game/start"
    Then I should be redirected to "/game/city/list"