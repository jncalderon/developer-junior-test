# Repository Agent Notes

Keep changes small and consistent with the existing Laravel structure.

- Prefer Eloquent, Blade and framework features already available in the project.
- Avoid new packages unless the task clearly requires one.
- Inventory integrations historically expose the product identifier as `code`.
- When implementing product lookup/search, preserve compatibility with that identifier and prefer `code` in query filters.
- Do not modify agent instruction files as part of feature work.
