@City @Create
    Feature: Create a city
        In order to create a city
        as registered player
        I have to find the right place
     
    Background:
        Given following tiles:
           | name | accessable |
           | Grass | yes |
           | Forrest | no |
           | Sea | no |
           | Hill | no |
        And a map "default" with following tiles:
         |   y/x   |   0   |   1   |   2   |   3   |   4   |
         |  0   | Grass | Grass | Grass | Grass | Grass |
         |  1   | Grass | Forrest | Grass | Grass | Grass |
         |  2   | Grass | Grass | Grass | Grass | Grass |
         |  3   | Grass | Sea | Grass | Hill | Grass |
         |  4   | Grass | Grass | Grass | Grass | Grass |
        And user with follwoing informations:
            | username | password | email |
            | BlackScorp | 123456 | test@test.de |
            | Owner1 | 123456 | owner1@test.de |
            | Owner2 | 123456 | owner2@test.de |
        And following cities:
            | name | owner | x | y |
            | City1 | Owner1 | 0 | 0 |
            | City2 | Owner2 | 2 | 0 |
            | City3 | Owner1 | 4 | 4 |
      
     
    Scenario: create a city
        Given I'm logged in as user "BlackScorp"
        When I create a city at location x=2 and y=2
        Then I should have a city

    Scenario: tile is not accessable
        Given I'm logged in as user "BlackScorp"
        When I create a city at location x=1 and y=1
        Then I should see "tile not accessable"

    Scenario: tile is not accessable
        Given I'm logged in as user "BlackScorp"
        When I create a city at location x=0 and y=0
        Then I should see "city found at location" 

