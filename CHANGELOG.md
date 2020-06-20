# Changelog

All notable changes to this project will be documented in this file, in reverse chronological order by release.

## 0.11.2 - 2020-06-20

### Added

- Nothing.

### Changed

- Nothing.

### Deprecated

- Nothing.

### Removed

- Nothing.

### Fixed

- [#57](https://github.com/weirdan/doctrine-psalm-plugin/pull/57) Allow classes extending query builder to return instances of themselves (thanks @enumag)

## 0.11.1 - 2020-04-16

### Added

- Nothing.

### Changed

- Nothing.

### Deprecated

- Nothing.

### Removed

- Nothing.

### Fixed

- [#55](https://github.com/weirdan/doctrine-psalm-plugin/pull/55) Fixed EntityManager::getReference() type to be nullable (thanks @seferov)

## 0.11.0 - 2020-03-30

### Added

- Nothing.

### Changed

- [#54](https://github.com/weirdan/doctrine-psalm-plugin/pull/54) EntityManager::getReference() return type changed to nullable (thanks @simPod)

### Deprecated

- Nothing.

### Removed

- Nothing.

### Fixed

- Nothing.

## 0.10.0 - 2020-02-27

### Added

- [#48](https://github.com/weirdan/doctrine-psalm-plugin/pull/48) Added stub for Doctrine\DBAL\Query\Expression\ExpressionBuilder (thanks @mpolyakovsky)

### Changed

- Nothing.

### Deprecated

- Nothing.

### Removed

- Nothing.

### Fixed

- [#49](https://github.com/weirdan/doctrine-psalm-plugin/pull/49) Allow WHERE IN clauses in the ORM QueryBuilder (thanks @jaikdean)

- [#50](https://github.com/weirdan/doctrine-psalm-plugin/pull/50) Fixed compatibility with Alpine Linux (missing GLOB_BRACE) (thanks @bendavies)

## 0.9.0 - 2020-01-19

### Added

- [#45](https://github.com/weirdan/doctrine-psalm-plugin/pull/29) Added support for DBAL Query Builder (thanks @mpolyakovsky)

### Changed

@orklah and @mpolyakovsky contributed a number of improvements to the test suite and other misc fixes

### Deprecated

- Nothing.

### Removed

- Support for Psalm older than 3.6.2

### Fixed

- Nothing.

## 0.8.0 - 2019-10-17

### Added

- [#29](https://github.com/weirdan/doctrine-psalm-plugin/pull/29) Added ClassMetadataInfo::$sequenceGeneratorDefinition

### Changed

- Nothing.

### Deprecated

- Nothing.

### Removed

- Nothing.

### Fixed

- Nothing.

## 0.7.1 - 2019-10-14

### Added

- Nothing.

### Changed

- Nothing.

### Deprecated

- Nothing.

### Removed

- Nothing.

### Fixed

- [#28](https://github.com/weirdan/doctrine-psalm-plugin/pull/28) [#27](https://github.com/weirdan/doctrine-psalm-plugin/issues/27) `Expr\Comparison` is now allowed in `QueryBuilder::{where,orWhere,andWhere}()`

## 0.7.0 - 2019-10-13

### Added

- [#26](https://github.com/weirdan/doctrine-psalm-plugin/pull/26) Support for variadic arguments of QueryBuilder methods (thanks @2e3s)

### Changed

- Nothing.

### Deprecated

- Nothing.

### Removed

- Nothing.

### Fixed

- Nothing.
