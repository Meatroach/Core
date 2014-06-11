@ActivateAccount
Feature: User Activation
  In order to login as registered user, I need to activate my account

  Background:
    Given following users:
      | username   | password  | email        | activationCode |
      | BlackScorp | 123456789 | test@tld.com | test           |

  Scenario: activate valid account
    Given I'am not logged in
    When I visit "account/activate/BlackScorp/test"
    Then I activate account with following informations:
      | username   | activationCode |
      | BlackScorp | test           |
    And I should be activated

  Scenario Outline: invalid activations
    Given I'am not logged in
    When I visit "<url>"
    Then I activate account with following informations:
      | username   | activationCode   |
      | <username> | <activationCode> |
    And I should not be activated
    And I should see following messages "<errorMessage>"

  Examples:
    | username   | activationCode | url                                | errorMessage               |
    | BlackScorp | 123456         | account/activate/BlackScorp/123456 | Activation code is invalid |
    | Test       | test           | account/activate/Test/test         | Activation code is invalid |

  Scenario Outline: invalid activation URLs
    Given I'am not logged in
    When I visit "<url>"
    Then I should get 404 errorpage

  Examples:
    | url                      |
    | account/activate//123456 |
    | account/activate/Test/   |

  Scenario: user already active
    Given I'am not logged in
    And "BlackScorp" is activated
    When I visit "account/activate/BlackScorp/test"
    Then I activate account with following informations:
      | username   | activationCode |
      | BlackScorp | test           |
    And I should not be activated
    And I should see following messages "Activation code is invalid"