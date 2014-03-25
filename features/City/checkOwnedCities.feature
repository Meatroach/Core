@CheckCities
Feature: check cities
In order to select a location for new City,
as registered player,
i should not have any cities

Background:
        Given following users:
            | username | password | email |
            | BlackScorp | 123456 | test@test.de |

Scenario: Redirect to select location page
    Given I'm logged in as user "BlackScorp"
    When I open "/"
    Then I should be redirected to "game/city/new"

Scenario: No redirects
    Given following cities:
            | name | owner | x | y | isMain |
            | City1 | BlackScorp | 0 | 0 | true |
            | City2 | BlackScorp | 0 | 0 | false |
    And I'm logged in as user "BlackScorp"
    When I open "/"
    Then I should be redirected to "game/city"

Scenario: Redirect from new city screen
    Given following cities:
            | name | owner | x | y | isMain |
            | City1 | BlackScorp | 0 | 0 | true |
            | City2 | BlackScorp | 0 | 0 | false |
    And I'm logged in as user "BlackScorp"
    When I open "game/city/new"
    Then I should be redirected to "game/city"