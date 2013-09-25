@Account @Login
Feature: User login
In order to to login as registered user, I have to input valid informations

Scenario: login with valid account
     Given user with follwoing informations:
       | Username | Password | Email |
       | BlackScorp | 123456 | test@test.de |
    And I'm not logged in
    And I have "Guest" roles
    When I login with following informations:
        | Username | Password |
        | BlackScorp | 123456  |
    Then I should be logged in
    And I should have "User" roles

Scenario: login with invalid Password
     Given user with follwoing informations:
       | Username | Password | Email |
       | BlackScorp | 123456 | test@test.de |
    And I'm not logged in
    And I have "Guest" roles
    When I login with following informations:
        | Username | Password |
        | BlackScorp | 654321  |
    Then I should see "invalid login informations" 

Scenario: login with invalid usename
     Given user with follwoing informations:
       | Username | Password | Email |
       | BlackScorp | 123456 | test@test.de |
    And I'm not logged in
    And I have "Guest" roles
    When I login with following informations:
        | Username | Password |
        | Black | 654321  |
    Then I should see "username not exists"

Scenario: login with not active account
     Given user with follwoing informations:
       | Username | Password | Email | activationCode |
       | BlackScorp | 123456 | test@test.de | qwerty |
    And I'm not logged in
    And I have "Guest" roles
    When I login with following informations:
        | Username | Password |
        | BlackScorp | 123456  |
    Then I should see "account is not active" 

Scenario: login with empty Username
     Given user with follwoing informations:
       | Username | Password | Email | 
       | BlackScorp | 123456 | test@test.de |
    And I'm not logged in
    And I have "Guest" roles
    When I login with following informations:
        | Username | Password |
        |  | 123456  |
    Then I should see "username not exists"

Scenario: login with short Username
     Given user with follwoing informations:
       | Username | Password | Email |
       | BlackScorp | 123456 | test@test.de |
    And I'm not logged in
    And I have "Guest" roles
    When I login with following informations:
        | Username | Password |
        | B | 123456  |
    Then I should see "username not exists" 

Scenario: login with long Username
     Given user with follwoing informations:
       | Username | Password | Email |
       | BlackScorp | 123456 | test@test.de |
    And I'm not logged in
    And I have "Guest" roles
    When I login with following informations:
        | Username | Password |
        | BlackScorpBlackScorpBlackScorpBlackScorpBlackScorpBlackScorp | 123456  |
    Then I should see "username not exists" 

Scenario: login with invalid Username
     Given user with follwoing informations:
       | Username | Password | Email |
       | BlackScorp | 123456 | test@test.de |
    And I'm not logged in
    And I have "Guest" roles
    When I login with following informations:
        | Username | Password |
        | B!@ckS@rp | 123456  |
    Then I should see "username not exists"

Scenario: login with empty Password
     Given user with follwoing informations:
       | Username | Password | Email |
       | BlackScorp | 123456 | test@test.de |
    And I'm not logged in
    And I have "Guest" roles
    When I login with following informations:
        | Username | Password |
        | BlackScorp |   |
    Then I should see "invalid login informations"

Scenario: login with short Password
     Given user with follwoing informations:
       | Username | Password | Email |
       | BlackScorp | 123456 | test@test.de |
    And I'm not logged in
    And I have "Guest" roles
    When I login with following informations:
        | Username | Password |
        | BlackScorp | 123 |
    Then I should see "invalid login informations"