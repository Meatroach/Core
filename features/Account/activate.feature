@ActivateAccount
Feature: User Activation
In order to login as registered user, I need to activate my account

Background:
    Given following users:
       | username | password | email | activationCode |
       | BlackScorp | 123456789 | test@tld.com | test |

Scenario: activate valid account
    Given I'am not logged in
    When I visit "account/activate/BlackScorp/test"
    Then I should be activated

Scenario Outline: invalid activations
    Given I'am not logged in
    When I visit "<url>"
    Then I should not be activated
    And I should see following messages "<errorMessage>"

Examples:
  | url  | username | activationCode | errorMessage |
  | account/activate/BlackScorp/123456  | BlackScorp | 123456 | Activation code is invalid |
   | account/activate/Test/test | Test | test | Activation code is invalid |
   |account/activate//123456 | | 123456 | Activation code is invalid |
   |account/activate/Test/ | Test | | Activation code is invalid |


Scenario: user already active
    Given I'am not logged in
    And "BlackScorp" is activated
   When I visit "account/activate/BlackScorp/test"
    Then I should not be activated
    And I should see following messages "Activation code is invalid"