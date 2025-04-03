# Laravel Security Tools

This project includes several security tools to help identify and prevent potentially harmful code from being committed to the repository.

## Security Pre-commit Hook

The pre-commit hook automatically checks your code for security issues before allowing commits. It's set up using Husky.

### Setup

Run the setup script to install and configure Husky with the security pre-commit hook:

```bash
./setup-husky.sh
```

Alternatively, you can install it via Composer, which will automatically copy the pre-commit hook:

```bash
composer install
```

### What it checks

The pre-commit hook performs the following checks:

1. Dangerous PHP functions (`shell_exec`, `eval`, etc.)
2. Dangerous database commands (`DROP DATABASE`, `DELETE FROM`, etc.)
3. File deletion code (`unlink`, `rmdir`, etc.)
4. PHP syntax validation
5. Code style using Laravel Pint
6. Credentials/secrets in code
7. .env file modifications
8. Dependency vulnerabilities
9. Potentially harmful scheduler tasks
10. Potentially dangerous code in middleware

### Bypassing the Hook

If you need to bypass the security checks for a specific commit, you can use:

```bash
git commit --no-verify
```

**Note:** Only bypass the checks if you're absolutely sure about what you're committing.

## Security Check Scripts

There are two security check scripts available for testing your codebase:

### Regular Security Check

You can manually run a security check on your entire project:

```bash
./security-check.sh
```

Or using npm:

```bash
npm run security-check
```

Or using Composer:

```bash
composer security-check
```

### Comprehensive Security Test

For a more thorough security analysis, including additional checks like Git history, file permissions, and more:

```bash
./security-test.sh [path-to-project]
```

Or using Composer:

```bash
composer security-test
```

This script can be run on any Laravel project by providing the path as an argument, or on the current project if no path is specified.

### Additional Features in security-test.sh

The comprehensive test includes all the checks from security-check.sh plus:

1. Git history analysis for suspicious commits
2. Unprotected routes detection
3. File permission checks
4. Environment configuration validation
5. Code quality tests with multiple tools (PHPStan, PHPCS, Pint, Enlightn)
6. Config files analysis
7. Check for suspicious code in event listeners

## Code Quality Tools

The project includes several code quality tools that can be run through Composer:

```bash
# Run all code quality checks (PHP-CS-Fixer, PHPStan, Laravel Pint)
composer lint

# Fix code style issues automatically
composer lint-fix

# Run pre-commit hook manually
composer pre-commit
```

## Production Environment Checklist

Before deploying to production, make sure to:

1. Set `APP_DEBUG=false` in .env
2. Set `APP_ENV=production` in .env
3. Ensure all dependencies are up to date (`composer update`)
4. Check for security vulnerabilities (`composer audit`)
5. Set proper file permissions:
   - .env: 600 (`chmod 600 .env`)
   - storage: 755 (`chmod -R 755 storage`)
   - bootstrap/cache: 755 (`chmod -R 755 bootstrap/cache`)

## Additional Resources

- [Laravel Security Best Practices](https://laravel.com/docs/10.x/security)
- [PHP Security Cheat Sheet](https://cheatsheetseries.owasp.org/cheatsheets/PHP_Security_Cheat_Sheet.html)
- [OWASP Top Ten](https://owasp.org/www-project-top-ten/) 

## Quick Guide

- Run `./setup-husky.sh` or `composer install` to initialize everything
- Husky will automatically run the pre-commit checks before each commit
- Run `composer security-check` for regular security audits
- Run `composer security-test` for comprehensive security testing
- Use `composer lint` to check code quality
- Use `composer lint-fix` to automatically fix code style issues
- If needed, bypass security checks with `git commit --no-verify` 