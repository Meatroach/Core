@AccountLogin
Feature: User login
In order to to login as registered user, I have to input valid informations

Background: 
    Given following users:
        | username | password | email | activationCode |
        | BlackScorp | 123456 | test@tld.com | |
        | NotActive | 123456 | test@test2.com | test |


Scenario: login with valid account
    Given I'am on site "/"
    And I'am not logged in
    When I login with following informations:
        | username | password |
        | BlackScorp | 123456  |
    Then I should be logged in

Scenario Outline: login with invalid informations
    Given I'am on site "/"
    And I'am not logged in
    When I login with following informations:
        | username | password |
        | <username> | <username>  |
    Then I should not be logged in  

Examples:
    | username | password |
    | | |
    | Test | |
    | | 12345 |
    | Test | 1234 |
    | NotActive | 123456 |

