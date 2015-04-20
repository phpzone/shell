Feature: An option to force a stop on a script error
  As a developer
  I want to have an option to force a stop on the first script error
  So I can avoid to process of remaining scripts

  Scenario: One of the scripts has an error and I want to promptly stop
    Given there is a config file with:
      """
      extensions:
          PhpZone\Shell\Shell:
              'command:one':
                  script:
                      - php -r "exit(1);"
                      - echo text script 2

      """
    When I run phpzone with "command:one" and "--stop-on-error"
    Then I should see an error
    And I should see:
      """
      """
