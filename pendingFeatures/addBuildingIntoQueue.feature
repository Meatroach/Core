@AddBuilding
Feature: add building to the queue
    In order to build a building
    As registered user
    I must fullfill the requirements

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
    And following resources:
        | Name | 
        | Stone | 
        | Iron | 
        | Wood | 
        | Population | 
    And following building costs:
        | building | resource | value | factor |
        | Headquarters | Wood | 90 | 1.26 |
        | Headquarters | Stone | 80 | 1.275 |
        | Headquarters | Iron | 70 | 1.26 |
        | Headquarters | Population | 5 | 1.17 |
        | Barracks | Wood | 200 | 1.26 |
        | Barracks | Stone | 170 | 1.28 |
        | Barracks | Iron | 90 | 1.26 |
        | Barracks | Population | 7 | 1.17 |
        | Stable | Wood | 270 | 1.26 |
        | Stable | Stone | 240 | 1.28 |
        | Stable | Iron | 260 | 1.26 |
        | Stable | Population | 8 | 1.17 |
        | Workshop | Wood | 300 | 1.26 |
        | Workshop | Stone | 240 | 1.28 |
        | Workshop | Iron | 260 | 1.26 |
        | Workshop | Population | 8 | 1.17 |
        | Academy | Wood | 15000 | 2 |
        | Academy | Stone | 25000 | 2 |
        | Academy | Iron | 10000 | 2 |
        | Academy | Population | 80 | 1.17 |
        | Smithy | Wood | 220 | 1.26 |
        | Smithy | Stone | 180 | 1.275 |
        | Smithy | Iron | 240 | 1.26 |
        | Smithy | Population | 20 | 1.17 |
        | Rally point | Wood | 10 | 1.26 |
        | Rally point | Stone | 40 | 1.275 |
        | Rally point | Iron | 30 | 1.26 |
        | Rally point | Population | 0 | 1.17 |
        | Market | Wood | 100 | 1.26 |
        | Market | Stone | 100 | 1.275 |
        | Market | Iron | 100 | 1.26 |
        | Market | Population | 20 | 1.17 |
        | Timber camp | Wood | 50 | 1.25 |
        | Timber camp | Stone | 60 | 1.275 |
        | Timber camp | Iron | 40 | 1.245 |
        | Timber camp | Population | 5 | 1.155 |
        | Clay pit | Wood | 65 | 1.27 |
        | Clay pit | Stone | 50 | 1.265 |
        | Clay pit | Iron | 40 | 1.24 |
        | Clay pit | Population | 10 | 1.14 |
        | Iron mine | Wood | 76 | 1.252 |
        | Iron mine | Stone | 65 | 1.275 |
        | Iron mine | Iron | 70 | 1.24 |
        | Iron mine | Population | 10 | 1.17 |
        | Farm | Wood | 45 | 1.252 |
        | Farm | Stone | 40 | 1.275 |
        | Farm | Iron | 30 | 1.24 |
        | Farm | Population | 0 | 1.17 |
        | Warehouse | Wood | 60 | 1.265 |
        | Warehouse | Stone | 50 | 1.27 |
        | Warehouse | Iron | 40 | 1.245 |
        | Warehouse | Population | 0 | 1.15 |
        | Hiding place | Wood | 50 | 1.25 |
        | Hiding place | Stone | 60 | 1.25 |
        | Hiding place | Iron | 50 | 1.25 |
        | Hiding place | Population | 2 | 1.17 |
        | Wall | Wood | 50 | 1.26 |
        | Wall | Stone | 100 | 1.275 |
        | Wall | Iron | 20 | 1.26 |
        | Wall | Population | 5 | 1.17 |
    And following building times:    
        | building | time | factor |
        | Headquarters | 900 | 1.2 |
        | Barracks | 1800 | 1.2 |
        | Stable | 6000 | 1.2 |
        | Workshop | 6000 | 1.2 |
        | Academy | 64800 | 1.2 |
        | Smithy | 6000 | 1.2 |
        | Rally point | 1200 | 1.2 |
        | Market | 2700 | 1.2 |
        | Timber camp | 900 | 1.2 |
        | Clay pit | 900 | 1.2 |
        | Iron mine | 1080 | 1.2 |
        | Farm | 1200 | 1.2 |
        | Warehouse | 1020 | 1.2 |
        | Hiding place | 1800 | 1.2 |
        | Wall | 3600 | 1.2 |
    And following users:
        | username | password | email |
        | BlackScorp | 123456 | test@test.de |
    And following cities:
        | name | owner | x | y |
        | BlackScorp's Village | BlackScorp | 0 | 0 |
    And following techtree:
        | building | require | level |
        | Headquarters | | |
        | Hiding place | | |
        | Farm | | |
        | Warehouse | | |
        | Rally point | | |
        | Iron mine | | |
        | Clay pit | | |
        | Timber camp | | |
        | Market | Headquarters | 3 |
        | Market | Warehouse | 2 |
        | Barracks | Headquarters | 3 |
        | Wall | Barracks | 1 |
        | Smithy | Headquarters | 5 | 
        | Smithy | Barracks | 1 |
        | Stable | Barracks | 5 |
        | Stable | Smithy | 5 |
        | Stable | Headquarters | 10 |
        | Workshop | Smithy | 10 |
        | Workshop | Headquarters | 10 |
        | Workshop | Stable | 1 |
        | Academy | Headquarters | 20 |
        | Academy | Market | 10 |
        | Academy | Smithy | 20 |
        
Scenario: build a building
    Given I'm logged in as user "BlackScorp"
    And I have a city
    And the city have following buildings:
        | name | level |
        | Headquarters | 3 |
    And the city have following resources:
       | name | amount |
       | Wood | 300 |
       | Iron | 300 |
       | Stone | 300 |
    When I build "Barracks"
    Then I should have "Barracks" in building Queue
    And city should have following resources:
        | name | amount |
        | Wood | 100 |
        | Stone | 130 |
        | Iron | 210 |

Scenario: Building queue is full
  Given I'm logged in as user "BlackScorp"
    And I have a city
    And the city have following buildings:
        | name | level |
        | Headquarters | 3 |
    And the city have following resources:
       | name | amount |
       | Wood | 300 |
       | Iron | 300 |
       | Stone | 300 |
    And building queue has 3 actions
    When I build "Barracks"
    Then I should see "building queue full"

Scenario: not fullfill the requirements
  Given I'm logged in as user "BlackScorp"
    And I have a city
    And the city have following resources:
       | id | name | amount |
       | 1 | Wood | 300 |
       | 2 | Iron | 300 |
       | 3 | Stone | 300 |
    When I build "Market"
    Then I should see "cannot build building"

Scenario: invalid building
  Given I'm logged in as user "BlackScorp"
    And I have a city
    And the city have following resources:
       | id | name | amount |
       | 1 | Wood | 300 |
       | 2 | Iron | 300 |
       | 3 | Stone | 300 |
    When I build "TestBuilding"
    Then I should see "building not exists"
