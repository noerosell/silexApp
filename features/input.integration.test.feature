Feature: Input format
  In order to consume the Twiter Rest Api
  As a consumer
  I need check Twitter response format

  Scenario: Request 10 Twits
    Given: a valid twitter user screen_name
    When : I request 10 twits for a given screen_name
    Then : I should receive 10 twits in format which we can parse.