Feature: Specifying a batch of scripts
  As a developer
  I want to be able to specify batch of scripts
  So I can run script by one command

  Scenario: Specifying one script
    Given there is a config file with:
      """
      extensions:
          PhpZone\Shell\Shell:
              'command:one':
                  - echo test 1
                  - echo test 2

      """
    When I run phpzone with "command:one"
    Then I should see:
      """
      test 1
      test 2

      """
