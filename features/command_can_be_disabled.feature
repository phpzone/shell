Feature: Command can be disabled
  As a developer
  I want to be able to disable a command
  So I can disable any configured command

  Scenario: Disabling command
    Given there is a config file with:
      """
      extensions:
          PhpZone\Shell\Shell:
              'command:one':
                  enable: false
                  script:
                      - echo test 1
              'command:two':
                  script:
                      - echo test 2

      """
    When I run phpzone
    Then I should have "command:two" command
    And I should not have "command:one" command
