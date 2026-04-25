# `lyre/settings` Agent Guide

## Package Purpose
`lyre/settings` manages application and tenant-scoped key/value settings and provides a global `setting()` helper plus Filament management UI.

## What Belongs In This Package
- `Setting` model/repository/controller/resource.
- settings helper (`setting()`), provider bindings, Filament settings resource/plugin.

## What Does Not Belong Here
- General content/page composition.
- App-specific custom settings business rules that should live in host apps.

## Public API / Stable Contracts
- `setting(string $key, $default = null)` helper contract.
- `Setting::get` and `Setting::set` tenant-aware behavior.
- Settings Filament plugin menu behavior.

## Internal Areas That May Change
- Internal generator implementation details in `Setting::generateValue`, preserving callable contract.

## Usage Rules
- Use settings for low-volume configuration-like values, not high-throughput domain data.
- Be explicit when values are tenant-specific versus global defaults.

## Extension Rules
- Preserve key naming/tenant suffix behavior for backward compatibility.
- If adding HTTP routes, do so intentionally and document because route file is currently empty.

## Testing Requirements
- Validate `setting()` fallback behavior with and without tenant context.
- Validate settings writes/reads through repository/controller and Filament resource.

## Docs To Update When This Package Changes
- Root [AGENTS.md](/Users/chegekigathi/Projects/packages/lyre-packages/AGENTS.md)
- [docs/package-responsibilities.md](/Users/chegekigathi/Projects/packages/lyre-packages/docs/package-responsibilities.md)
- Add/update `packages/settings/README.md` if public usage changes
