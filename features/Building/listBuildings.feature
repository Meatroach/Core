@ListBuildings
Feature: List Buildings
In order to create buildings,
as registered player,
I have to list my buildings

Background:
      Given following Buildings:
        | name | minimumLevel | maximumLevel | 
        | Headquarters |  1 | 30 |
        | Barracks | 0 | 25 |
        | Stable | 0 | 20 |
        | Workshop | 0 | 15 |
        | Academy | 0 | 3 |
        | Smithy | 0 | 20 |
        | Rally point | 0 | 1 |
        | Market | 0 | 25 |
        | Timber camp | 0 | 30 |
        | Clay pit | 0 | 30 |
        | Iron mine | 0 | 30 |
        | Farm | 1 | 30 |
        | Warehouse | 1 | 30 |
        | Hiding place | 0 | 10 |
        | Wall | 0 | 20 |
      And following users:
            | username | password | email |
            | BlackScorp | 123456 | test@test.de |
            | TestUser  | 123456 | test2@test.de |
      And following cities:
            | name | owner | x | y |
            | City1 | BlackScorp | 0 | 0 |
            | City2 | TestUser | 1 | 1 |

Scenario: List my buildings
    Given I'm logged in as user "BlackScorp"
    When I visit "game/city/0/0"
    Then I selected the city at y=0 and x=0
    And I should see following buildings
        | name | level |
        | Headquarters |  1 | 
        | Barracks | 0 | 
        | Stable | 0 |
        | Workshop | 0 | 
        | Academy | 0 | 
        | Smithy | 0 | 
        | Rally point | 0 | 
        | Market | 0 | 
        | Timber camp | 0 | 
        | Clay pit | 0 |
        | Iron mine | 0 | 
        | Farm | 1 | 
        | Warehouse | 1 | 
        | Hiding place | 0 | 
        | Wall | 0 | 