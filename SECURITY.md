# Security Measures

This project includes several security measures to help ensure code quality and prevent potentially dangerous code from being committed to the repository.

## Pre-commit Hook

A Git pre-commit hook has been set up to run automatically before each commit. This hook performs the following checks:

1. **Dangerous PHP Functions**: Detects potentially harmful functions like `shell_exec`, `exec`, `eval`, etc.
2. **Dangerous Database Commands**: Identifies database commands like `DROP TABLE`, `DELETE FROM`, etc.
3. **File Deletion Code**: Checks for file system operations that delete files or directories.
4. **PHP Syntax Validation**: Ensures all PHP files have valid syntax.
5. **Code Quality Tools**: Runs PHP CS Fixer, PHPStan, and Laravel Pint if available.
6. **Secrets Detection**: Looks for credentials or secrets in the code.
7. **Environment File Check**: Prevents committing `.env` files.
8. **Dependency Vulnerability Check**: Scans for known vulnerabilities in dependencies.
9. **Scheduler Task Analysis**: Examines Laravel scheduler tasks for potentially harmful operations.

## Manual Security Check

You can run a manual security check on the codebase by using:

```bash
npm run security-check
```

This will scan the entire codebase for the same issues and report any findings without blocking a commit.

## Setting Up

The security checks are installed via Husky. If you've just cloned the repository, run:

```bash
npm install
```

This will automatically set up the Git hooks.

## Bypassing Checks

In cases where you need to bypass the pre-commit hook (for example, when knowingly using a potentially dangerous function in a controlled way), you can use:

```bash
git commit --no-verify
```

**Note**: This should be done with caution and only when you understand the implications. 