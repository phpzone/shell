# PhpZone Shell

[![Build Status](https://travis-ci.org/phpzone/shell.svg?branch=master)](https://travis-ci.org/phpzone/shell)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/phpzone/shell/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/phpzone/shell/?branch=master)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/e00091c2-2be6-4bc3-a72f-1b92be8204dd/mini.png)](https://insight.sensiolabs.com/projects/e00091c2-2be6-4bc3-a72f-1b92be8204dd)

[![Latest Stable Version](https://poser.pugx.org/phpzone/shell/v/stable.png)](https://packagist.org/packages/phpzone/shell)
[![Total Downloads](https://poser.pugx.org/phpzone/shell/downloads.png)](https://packagist.org/packages/phpzone/shell)
[![License](https://poser.pugx.org/phpzone/shell/license.png)](https://packagist.org/packages/phpzone/shell)

A command/script builder configured by [YAML], based on [PhpZone]. Its primary purpose is to
provide an easy way to define multiple scripts used in daily workflow of every developer.

## Basic Usage

An example speaks a hundred words so let’s go through one.

The configuration file below is used for a development of this extension:

```yaml
extensions:
    PhpZone\Shell\Shell:
        tests:
            description: Run all tests
            script:
                - bin/behat -f progress
                - bin/phpunit
                - bin/phpspec run -f progress
                - bin/phpcs -p --colors --standard=PSR2 src/ features/bootstrap/
                - bin/phpcs -p --colors --standard=vendor/jakubzapletal/php_codesniffer-rules/psr2-without-camel-case-method-name.xml spec/ integrations/
```

Now we can just run following command and all tests would be executed:

```bash
$ vendor/bin/phpzone tests
```

## Documentation

For more details visit [PhpZone Shell documentation].


[YAML]: http://symfony.com/doc/current/components/yaml/yaml_format.html
[PhpZone]: https://github.com/phpzone/phpzone
[PhpZone Shell documentation]: http://www.phpzone.org/projects/phpzone-shell
