Feature: Defining a stop on a script error
  As a developer
  I want to be able to define a stop on the first script error
  So I can avoid to process of remaining scripts

  Scenario: One of the scripts has an error and the prompt stop is not defined
    Given there is a config file with:
      """
      extensions:
          PhpZone\Shell\Shell:
              'command:one':
                  script:
                      - php -r "exit(1);"
                      - echo text script 2

      """
    When I run phpzone with "command:one"
    Then I should see an error
    And I should see:
      """
      text script 2

      """
  Scenario: One of the scripts has an error and the prompt stop is defined
    Given there is a config file with:
      """
      extensions:
          PhpZone\Shell\Shell:
              'command:two':
                  stop_on_error: true
                  script:
                      - php -r "exit(1);"
                      - echo text script 2

      """
    When I run phpzone with "command:two"
    Then I should see an error
    And I should see:
      """

        Remaining scripts:
        2) echo text script 2


      """
