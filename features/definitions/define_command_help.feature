Feature: Defining a help for command
  As a developer
  I want to be able to define a help for command
  So I can provide better explanation how the command works or to use

  Scenario: Defining a help for command
    Given there is a config file with:
      """
      extensions:
          PhpZone\Shell\Shell:
              'command:three':
                  help: Some help text
                  script:
                      - echo test 1

      """
    When I run phpzone with "command:three"
    Then I should see "Some help text" in "command:three" command help
