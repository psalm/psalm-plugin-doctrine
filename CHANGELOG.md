# Changelog

All notable changes to this project will be documented in this file, in reverse chronological order by release.

## 1.0.0 - 2021-01-03

### Added

- [#61](https://github.com/weirdan/doctrine-psalm-plugin/pull/61) Added taint sinks for DBAL\Connection (@adrienlucas)

- [#67](https://github.com/weirdan/doctrine-psalm-plugin/pull/67) [#66](https://github.com/weirdan/doctrine-psalm-plugin/issues/66) Allow pushed to ArrayCollection

- [#64](https://github.com/weirdan/doctrine-psalm-plugin/pull/64) [#63](https://github.com/weirdan/doctrine-psalm-plugin/issues/63) EntityRepository::matching() stub (@ygottschalk)

### Changed

- [#72](https://github.com/weirdan/doctrine-psalm-plugin/pull/72) [#71](https://github.com/weirdan/doctrine-psalm-plugin/issues/71) Return type of ObjectRepository::findAll() from list<T> to T[]

- [#62](https://github.com/weirdan/doctrine-psalm-plugin/pull/62) Test on Symfony 5 (@amberovsky)

### Deprecated

- Nothing.

### Removed

- [#78](https://github.com/weirdan/doctrine-psalm-plugin/pull/78) Removed support for Psalm <4.3.2 (@tugmaks)

### Fixed

- [#75](https://github.com/weirdan/doctrine-psalm-plugin/pull/75) [#69](https://github.com/weirdan/doctrine-psalm-plugin/issues/69) MethodSignatureMismatch on EntityManager methods

- [#74](https://github.com/weirdan/doctrine-psalm-plugin/pull/74) [#70](https://github.com/weirdan/doctrine-psalm-plugin/issues/70) ManagerRegistry deprecation/removal

## 0.11.3 - 2020-06-21

### Added

- Nothing.

### Changed

- Changed stub files extension to hide them from some IDEs

### Deprecated

- Nothing.

### Removed

- Nothing.

### Fixed

- Nothing.

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
