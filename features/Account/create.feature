@Account @Create
Feature: User registration
In order to create an account as unregistered user, I have to input valid values

Scenario: create new account with valid data
    Given I'm not registered user
    And I have "Guest" roles
    When I register with following informations:
        | username | password | password_confirm | email | email_confirm |
        | BlackScorp | 123456  | 123456 | test@test.de | test@test.de |
    Then I should be registered
    And I should get an activation code
    And I should get an email with activation code

Scenario: username empty
    Given I'm not registered user
    And I have "Guest" roles
    When I register with following informations:
        | username | password | password_confirm | email | email_confirm |
        |  | 123456  | 123456 | test@test.de | test@test.de |
    Then the registration should fail
    And I should see a message "Username is empty"

Scenario: username too short
    Given I'm not registered user
    And I have "Guest" roles
    When I register with following informations:
        | username | password | password_confirm | email | email_confirm |
        | b | 123456  | 123456 | test@test.de | test@test.de |
    Then the registration should fail
    And I should see a message "Username must contain at least 4 characters"

Scenario: username too long
    Given I'm not registered user
    And I have "Guest" roles
    When I register with following informations:
        | username | password | password_confirm | email | email_confirm |
        | blackscorpblackscorpblackscorpblackscorp | 123456  | 123456 | test@test.de | test@test.de |
    Then the registration should fail
    And I should see a message "Username can not be longer than 32 characters"

Scenario: username has invalid character
    Given I'm not registered user
    And I have "Guest" roles
    When I register with following informations:
        | username | password | password_confirm | email | email_confirm |
        | b@ckscorp! | 123456  | 123456 | test@test.de | test@test.de |
    Then the registration should fail
    And I should see a message "Username has invalid characters"

Scenario: username already exists
    Given I'm not registered user
    And I have "Guest" roles
    And user with follwoing informations:
       | id | username | password | email |
       | 1 | BlackScorp | 123456 | test@test.de |
    When I register with following informations:
        | username | password | password_confirm | email | email_confirm |
        | BlackScorp | 123456  | 123456 | test@test.de | test@test.de |
    Then the registration should fail
    And I should see a message "Username already exists"

Scenario: empty email
    Given I'm not registered user
    And I have "Guest" roles
    When I register with following informations:
        | username | password | password_confirm | email | email_confirm |
        | BlackScorp | 132456 | 132456 |  | test@test.de |
    Then the registration should fail
    And I should see a message "email is empty"

Scenario: email already exists
    Given I'm not registered user
    And I have "Guest" roles
    And user with follwoing informations:
      | id | username | password | email |
      | 1 | BlackScorp | 123456 | test@test.de |
    When I register with following informations:
        | username | password | password_confirm | email | email_confirm |
        | Black | 123456  | 123456 | test@test.de | test@test.de |
    Then the registration should fail
    And I should see a message "email already exists"

Scenario: email is invalid
    Given I'm not registered user
    And I have "Guest" roles
    When I register with following informations:
        | username | password | password_confirm | email | email_confirm |
        | blackscorp | 123456  | 123456 | test@test | test@test.de |
    Then the registration should fail
    And I should see a message "email is invalid"

Scenario: empty password
    Given I'm not registered user
    And I have "Guest" roles
    When I register with following informations:
        | username | password | password_confirm | email | email_confirm |
        | BlackScorp |  | 132456 | test@test.de | test@test.de |
    Then the registration should fail
    And I should see a message "Password is empty"

Scenario: password too short
    Given I'm not registered user
    And I have "Guest" roles
    When I register with following informations:
        | username | password | password_confirm | email | email_confirm |
        | BlackScorp | 123 | 132456 | test@test.de | test@test.de |
    Then the registration should fail
    And I should see "Password must contain at least 6 characters"

Scenario: incorrect password confirm 
    Given I'm not registered user
    And I have "Guest" roles
    When I register with following informations:
        | username | password | password_confirm | email | email_confirm |
        | BlackScorp | 123456  | 132456 | test@test.de | test@test.de |
    Then the registration should fail
    And I should see "password confirm does not match the password"

Scenario: incorrect email confirm 
    Given I'm not registered user
    And I have "Guest" roles
    When I register with following informations:
        | username | password | password_confirm | email | email_confirm |
        | BlackScorp | 123456  | 123456 | test@test.de | test@test1.de |
    Then the registration should fail
    And I should see "email confirm does not match the email"