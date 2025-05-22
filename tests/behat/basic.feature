@theme @theme_mawang
Feature: Basic tests for Mawang

  @javascript
  Scenario: Plugin theme_mawang appears in the list of installed additional plugins
    Given I log in as "admin"
    When I navigate to "Plugins > Plugins overview" in site administration
    And I follow "Additional plugins"
    Then I should see "Mawang"
    And I should see "theme_mawang"
