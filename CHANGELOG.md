# Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]
- Cache the response
- Send 304 Not Modified responses when the file on disk has not changed

## [0.1.0] - 2019-06-18
- Added an `ImageRenderer` facade.
- Transformers can now be registered using the `ImageRenderer::addTransformer()` method.
- Added support for sub-directories.
