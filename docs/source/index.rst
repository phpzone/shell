PhpZone Shell
=============

.. toctree::
    :hidden:
    :caption: Shell
    :numbered:

    getting-started
    definitions-for-command
    options-for-command

.. toctree::
    :hidden:
    :caption: Links

    PhpZone <http://docs.phpzone.org>
    PhpZone Docker <http://docs.phpzone.org/projects/phpzone-docker>


A command/script builder configured by `YAML`_, based on `PhpZone`_. Its primary purpose is to
provide an easy way to define multiple scripts used in daily workflow of every developer.

Basic Usage
-----------

An example speaks a hundred words so let’s go through one.

The configuration file below is used for the development of this extension:

.. literalinclude:: ../../phpzone.yml
    :language: yaml

Now we can just run following command and all tests would be executed:

.. code-block:: bash

    $ vendor/bin/phpzone tests


.. _YAML: http://symfony.com/doc/current/components/yaml/yaml_format.html
.. _PhpZone: http://docs.phpzone.org
