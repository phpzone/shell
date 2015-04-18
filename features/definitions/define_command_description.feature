Feature: Defining a description for command
  As a developer
  I want to be able to define a description for command
  So I can see what defined command does

  Scenario: Defining a description for a command
    Given there is a config file with:
      """
      extensions:
          PhpZone\Shell\Shell:
              'command:two':
                  description: Test command description
                  script:
                      - echo test 1

      """
    When I run phpzone with "command:two"
    Then I should see "Test command description" in "command:two" command description
