# Change Log
All notable changes to this project will be documented in this file.

## [Unreleased][unreleased]
### Added
- Definition `tty` to enable/disable TTY mode.
- Definition `enable` to enable/disable a command.
- Definition `help` for a command help.

### Fixed
- BC changes for extensions in PhpZone 0.2.

## [0.1.2] - 2015-04-10
### Changed
- Set PhpZone dependency on 0.1.*

## [0.1.1] - 2015-04-08
### Added
- Option `--no-tty` to disable TTY mode.

### Fixed
- Issue in an output of some applications by running process asynchronously and with TTY enabled.

## 0.1.0 - 2015-04-08
### Added
- Definition `description` for a command description.
- Implementation for running basic batch of scripts by the `script` definition.

[unreleased]: https://github.com/phpzone/shell/compare/0.1.2...HEAD
[0.1.2]: https://github.com/phpzone/shell/compare/0.1.1...0.1.2
[0.1.1]: https://github.com/phpzone/shell/compare/0.1.0...0.1.1
