Feature: Defining a batch of scripts
  As a developer
  I want to be able to define a batch of scripts
  So I can run a batch of scripts by one command

  Scenario: Defining one script
    Given there is a config file with:
      """
      extensions:
          PhpZone\Shell\Shell:
              'command:one':
                  script:
                      - echo test 1
                      - echo test 2

      """
    When I run phpzone with "command:one"
    Then I should see:
      """
      test 1
      test 2

      """
