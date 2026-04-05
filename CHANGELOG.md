# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.1.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [1.0.0] - 2026-04-04

### Added
- Star rating field for Laravel Nova 5
- `outOf()` method to set maximum rating value (default: 5)
- `clearable()` method to enable rating reset
- `allowHalf()` method for half-star increments
- `color()` method for custom filled icon color (hex/rgb/hsl)
- `svg()` method for custom SVG icon from file path
- `emoji()` method for emoji character as icon
- Half-star input via click position detection
- Readonly support via Nova's built-in `readonly()` method
- Accessibility attributes (ARIA roles and labels)
- Dark mode support
