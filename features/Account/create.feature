@CreateAccount
Feature: User registration
In order to create an account as unregistered user, I have to input valid informations

Background:
    Given following users:
        | username | password | email |
        | TestUser | 123456789 | test@tld.com |


Scenario: create new account with valid data
    Given I'm not registered user
    When I register with following informations:
        | username | password | passwordConfirm | email | emailConfirm | termsAndConditions |
        | BlackScorp | 123456  | 123456 | test@test.de | test@test.de | checked |
    Then I should be registered
    And I should have an activation code

Scenario Outline: create new account over Web
    Given I'am on site "account/create"
     When I register with following informations on site:
        | username | password | passwordConfirm | email | emailConfirm | termsAndConditions |
        | <username> | <password>  | <passwordConfirm> | <email>| <emailConfirm> | <termsAndConditions> |
     Then I should not be registered on site
     And I should see following messages "<errorMessage>"  on site

Examples:
    | username | password | passwordConfirm | email | emailConfirm | termsAndConditions | errorMessage |
    |  | 123456 | 123456 | test@test.de | test@test.de | checked | Username is empty |
    | b | 123456 | 123456 | test@test.de |  test@test.de |  checked | Username is too short |
    | BlackScorp Test | 123456 | 123456 | test@test.de | test@test.de |  checked | Username contains invalid character |
    | BläckScörp | 123456 | 123456 | test@test.de | test@test.de |  checked | Username contains invalid character |
    | TestUser | 123456 | 123456 | test@test.de | test@test.de | checked | Username exists |
    | BlackScorpBlackScorpBlackScorpBlackSCorpBlackScorp | 123456 | 123456 | test@test.de | test@test.de |  checked | Username is too long |
    | BlackScorp |  | | test@test.de | test@test.de |  checked | Password is empty |
    | BlackScorp | 123 | 123 | test@test.de | test@test.de |  checked | Password is too short |
    | BlackScorp | 123456 | 123 | test@test.de | test@test.de |  checked | Password confirm not match |
    | BlackScorp | 123456 | 123456 |  |  |  checked | Email is empty |
    | BlackScorp | 123456 | 123456 | test | test |  checked | Email is invalid |
    | BlackScorp | 123456 | 123456 | test@test.de | test |  checked | Email confirm not match |
    | BlackScorp | 123456 | 123456 | test@tld.com | test@tld.com  | checked | Email exists |
    | BlackScorp | 123456 | 123456 | test@test.de | test@test.de |  | Terms and Conditions are not accepted |

Scenario Outline: create new account with invalid data
     Given I'm not registered user
     When I register with following informations:
        | username | password | passwordConfirm | email | emailConfirm | termsAndConditions |
        | <username> | <password>  | <passwordConfirm> | <email>| <emailConfirm> | <termsAndConditions> |
     Then I should not be registered
     And I should see following messages "<errorMessage>"

Examples:
    | username | password | passwordConfirm | email | emailConfirm | termsAndConditions | errorMessage |
    |  | 123456 | 123456 | test@test.de | test@test.de | checked | Username is empty |
    | b | 123456 | 123456 | test@test.de |  test@test.de |  checked | Username is too short |
    | BlackScorp Test | 123456 | 123456 | test@test.de | test@test.de |  checked | Username contains invalid character |
    | BläckScörp | 123456 | 123456 | test@test.de | test@test.de |  checked | Username contains invalid character |
    | TestUser | 123456 | 123456 | test@test.de | test@test.de | checked | Username exists |
    | BlackScorpBlackScorpBlackScorpBlackSCorpBlackScorp | 123456 | 123456 | test@test.de | test@test.de |  checked | Username is too long |
    | BlackScorp |  | | test@test.de | test@test.de |  checked | Password is empty |
    | BlackScorp | 123 | 123 | test@test.de | test@test.de |  checked | Password is too short |
    | BlackScorp | 123456 | 123 | test@test.de | test@test.de |  checked | Password confirm not match |
    | BlackScorp | 123456 | 123456 |  |  |  checked | Email is empty |
    | BlackScorp | 123456 | 123456 | test | test |  checked | Email is invalid |
    | BlackScorp | 123456 | 123456 | test@test.de | test |  checked | Email confirm not match |
    | BlackScorp | 123456 | 123456 | test@tld.com | test@tld.com  | checked | Email exists |
    | BlackScorp | 123456 | 123456 | test@test.de | test@test.de |  | Terms and Conditions are not accepted |