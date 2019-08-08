# Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]
- Cache the response

## [0.2.1] - 2019-08-08
### Changes
- Updated the `composer.json` file to point to the correct Facade file for the `ImageRenderer` alias.


## [0.2.0] - 2019-06-22
### Added
- Response may return a 304 Not Modified if the file on disk has not changed and the request is the same regardless of cache status.
- The `cache.public` config setting was added.

### Changes
- The cache duration is now expressed in seconds and not minutes.

## [0.1.0] - 2019-06-18
- Added an `ImageRenderer` facade.
- Transformers can now be registered using the `ImageRenderer::addTransformer()` method.
- Added support for sub-directories.
