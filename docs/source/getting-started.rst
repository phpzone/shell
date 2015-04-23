Getting Started
===============

Requirements
------------

PhpZone requires PHP 5.3 or higher.

Installation
------------

Installation is provided via `Composer`_, if you don't have it, do install:

.. code-block:: bash

    $ curl -s https://getcomposer.org/installer | php

then PhpZone Shell can be added into your dependencies by:

.. code-block:: bash

    $ composer require --dev phpzone/shell 0.2.*

or add it manually into your ``composer.json``:

.. code-block:: json

    {
        "required-dev": {
            "phpzone/shell": "0.2.*"
        }
    }

Configuration file
------------------

If the configuration file doesn't exist yet, you can find more information in `PhpZone - Getting Started`_

Registration of the extension
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

Registration is provided by a simple definition of full name of the class (namespace included):

.. code-block:: yaml

    extensions:
        PhpZone\Shell\Shell: ~

.. note::
    This extension is a command builder with definitions within its values. It means that only the registration
    without any values would have no effect.

Creating of commands
^^^^^^^^^^^^^^^^^^^^

As mentioned in the PhpZone documentation, each extension gets its configuration via values which are defined during
its registration. PhpZone Shell expects to get an array of required commands. Each command has defined its name
as a key and its values are definitions for exact command:

.. code-block:: yaml

    extensions:
        PhpZone\Shell\Shell:
            'command:one':
                script:
                    - echo Command 1 is working
            'command:two':
                script:
                    - echo Command 2 is working

Now, when we would run:

.. code-block:: bash

    $ vendor/bin/phpzone command:one

we would see an output: ``Command 1 is working``


.. _Composer: https://getcomposer.org
.. _PhpZone - Getting Started: http://www.phpzone.org/en/latest/getting-started.html#configuration-file
