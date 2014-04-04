@ListCities
Feature: List cities
In order to select a city,
as registered user,
i have to list avaliable cities

Background:
        Given following users:
            | username | password | email |
            | BlackScorp | 123456 | test@test.de |
            | Owner1 | 123456 | owner1@test.de |
            | Owner2 | 123456 | owner2@test.de |
        And following cities:
            | name | owner | x | y |
            | City1 | BlackScorp | 0 | 0 |
            | City2 | BlackScorp | 2 | 0 |
            | City3 | Owner1 | 4 | 4 |

Scenario: List custom cities
    Given I'm logged in as user "BlackScorp"
    When I visit "/game/city/list"
    Then I selected user "BlackScorp"
    And I should see following cities:
            | name | owner | x | y |
            | City1 | BlackScorp | 0 | 0 |
            | City2 | BlackScorp | 2 | 0 |

Scenario: List custom cities
    Given I'm logged in as user "BlackScorp"
    When I visit "/game/city/list/Owner1"
    Then I selected user "Owner1"
    And I should see following cities:
            | name | owner | x | y |
            | City3 | Owner1 | 4 | 4 |

Scenario: empty city list
    Given I'm logged in as user "BlackScorp"
    When I visit "/game/city/list/Owner2"
    Then I selected user "Owner2"
    And I should see following cities:
            | name | owner | x | y |