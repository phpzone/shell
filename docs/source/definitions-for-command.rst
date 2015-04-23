Definitions For Command
=======================

Commands can contain following definitions:

+-------------+-------+-------+--------+
|Name         |Type   |Default|Required|
+=============+=======+=======+========+
|script       |array  |       |Yes     |
+-------------+-------+-------+--------+
|description  |string |null   |No      |
+-------------+-------+-------+--------+
|enable       |boolean|true   |No      |
+-------------+-------+-------+--------+
|help         |string |null   |No      |
+-------------+-------+-------+--------+
|stop_on_error|boolean|false  |No      |
+-------------+-------+-------+--------+
|tty          |boolean|true   |No      |
+-------------+-------+-------+--------+

Example:

.. code-block:: yaml

    extensions:
        PhpZone\Shell\Shell:
            command:
                script:
                    - echo Foo
                    - echo Bar
                description:   Short descriptive text
                enable:        true
                help:          Long helpful text
                stop_on_error: false
                tty:           true

.. note::
    The order of definitions can be random.

.. note::
    Not required definitions don't need to be set.

script
^^^^^^
======= ======= ========
Type    Default Required
======= ======= ========
array           Yes
======= ======= ========

A simple array of commands/scripts which should be executed. They are executed in exact order as defined.

description
^^^^^^^^^^^
======= ======= ========
Type    Default Required
======= ======= ========
string  null    No
======= ======= ========

The description of a command will be displayed when a developer would run the command ``list`` or without any command.

enable
^^^^^^
======= ======= ========
Type    Default Required
======= ======= ========
boolean true    No
======= ======= ========

All defined commands are enabled by default. Sometimes can be useful to disable a command without its removal.

help
^^^^
======= ======= ========
Type    Default Required
======= ======= ========
string  null    No
======= ======= ========

The help of a command will be displayed when a developer would run the command ``help``.

stop_on_error
^^^^^^^^^^^^^
======= ======= ========
Type    Default Required
======= ======= ========
boolean false   No
======= ======= ========

When some of defined commands in the script fails, remaining commands are still executed. If set to ``true``,
this definition forces to stop in case of any error and not attempt to execute remaining commands. A list of the
remaining commands will be displayed.

tty
^^^
======= ======= ========
Type    Default Required
======= ======= ========
boolean true    No
======= ======= ========

It is a definition of how commands are executed. By default all commands are executed in TTY mode.
