@Building
Feature: add building to the queue
    In order to build a building
    As registered user
    I must fullfill the requirements

Background:
    Given following Buildings:
        | id | name | 
        | 1 | Headquarters |  
        | 2 | Barracks |
        | 3 | Stable |
        | 4 | Workshop |
        | 5 | Academy |
        | 6 | Smithy |
        | 7 | Market |
        | 8 | Timber camp |
        | 9 | Clay pit |
        | 10 | Iron mine |
        | 11 | Farm |
        | 12 | Warehouse |
        | 13 | Hiding place |
        | 14 | Wall |
        | 15 | Rally point |
    And user with follwoing informations:
        | id | username | password | email |
        | 1 | BlackScorp | 123456 | test@test.de |
    And following cities:
        | id | name | owner | x | y |
        | 1 | BlackScorp's Village | BlackScorp | 0 | 0 |
    And following resources:
        | id | name |
        | 1 | Clay |
        | 2 | Iron |
        | 3 | Wood |
    And following techtree:
        | id | building | require | level |
        | 1 | Headquarters | | |
        | 2 | Hiding place | | |
        | 3 | Farm | | |
        | 4 | Warehouse | | |
        | 5 | Rally point | | |
        | 6 | Iron mine | | |
        | 7 | Clay pit | | |
        | 8 | Timber camp | | |
        | 9 | Market | Headquarters | 3 |
        | 10 | Market | Warehouse | 2 |
        | 11 | Barracks | Headquarters | 3 |
        | 12 | Wall | Barracks | 1 |
        | 13 | Smithy | Headquarters | 5 | 
        | 14 | Smithy | Barracks | 1 |
        | 15 | Stable | Barracks | 5 |
        | 16 | Stable | Smithy | 5 |
        | 17 | Stable | Headquarters | 10 |
        | 18 | Workshop | Smithy | 10 |
        | 19 | Workshop | Headquarters | 10 |
        | 20 | Workshop | Stable | 1 |
        | 21 | Academy | Headquarters | 20 |
        | 22 | Academy | Market | 10 |
        | 23 | Academy | Smithy | 20 |
        
Scenario: build a building
    Given I'm logged in as user "BlackScorp"
    And I have a city
    And the city have following buildings:
        | id | name | level |
        | 1 | Headquarters | 3 |
        | 2 | Hiding place | 1 |
        | 3 | Warehouse | 1 |
        | 4 | Rally point | 1 |
        | 5 | Iron mine | 1 |
        | 6 | Clay pit | 1 |
        | 7 | Timber camp | 1 |
        | 8 | Farm | 1 |
    And the city have following resources:
        | resource | amount |
        | Wood | 300 |
        | Iron | 300 |
        | Clay | 300 |
    When I build "Barracks"
    Then I should have "Barracks" in building Queue
    And city should have less resources

