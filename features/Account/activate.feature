@ActivateAccount
Feature: User Activation
In order to login as registered user, I need to activate my account

Background:
    Given following users:
       | username | password | email | activationCode |
       | BlackScorp | 123456789 | test@tld.com | test |

Scenario: activate valid account
    Given I'am not logged in
    When I activate account with following informations:
        | username | activationCode |
        | BlackScorp | test | 
    Then I should be activated

Scenario Outline: invalid activations
    Given I'am not logged in
    When I activate account with following informations:
        | username | activationCode |
        | <username> | <activationCode> | 
    Then I should not be activated
    And I should see following messages "<errorMessage>"

Examples:
    | username | activationCode | errorMessage |
    | BlackScorp | 123456 | Activation code is invalid |
    | Test | test | Activation code is invalid |
    | | 123456 | Activation code is invalid |
    | Test | | Activation code is invalid |


Scenario: user already active
    Given I'am not logged in
    And "BlackScorp" is activated
    When I activate account with following informations:
        | username | activationCode |
        | BlackScorp | 123456 | 
    Then I should not be activated
    And I should see following messages "Activation code is invalid"