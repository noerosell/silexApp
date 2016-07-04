Feature: Output format
  In order to integrate with other software
  As a consumer
  I need check the format response is ok

  Scenario: Requesting 10 twits
    Given: a valid twitter user screen_name
    When : I request 10 twits for a given screen_name
    Then : I should receive 10 twits in a correct format
