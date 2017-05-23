@signup
Feature: signup
  In order to register
  As a user
  I need to open the site and submit the signup form

  Scenario: try signup
    Given I open home page
    When I click on `Create Account` tab
    And I see submit form
    Then I submit the form
    And See my birthday on calendar
    Then I click on `Profile` link
    And See valid data