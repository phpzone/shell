Options For Command
===================

All built commands have their definitions of how they are executed, but sometimes it's useful to have an option
to rewrite defined parameter or extend a functionality. This is provided by options below.

Options are extended attributes which can be set either before command name or after command name, so both following
examples are valid:

.. code-block:: bash

    $ vendor/bin/phpzone <OPTION> <COMMAND>

.. code-block:: bash

    $ vendor/bin/phpzone <COMMAND> <OPTION>

.. tip::
    All available options can be displayed by:

    .. code-block:: bash

        $ vendor/bin/phpzone <COMMAND> --help

--stop-on-error
^^^^^^^^^^^^^^^

When some of defined commands in the script fails, remaining commands are still executed. If it is used, this option
forces to stop in case of any error and not attempt to execute remaining commands. For more details
there are displayed remaining commands which weren't executed. This option overwrites the ``stop_on_error``
`definition <definitions-for-command#stop-on-error>`_.

--no-tty
^^^^^^^^

In default all commands are executed in TTY mode. If this option is used, commands are not executed in TTY mode.
This option overwrites the ``tty``
`definition <definitions-for-command#tty>`_.


