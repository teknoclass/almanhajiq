#!/bin/bash
# Laravel Security Check Script
# This script can be run manually to perform security checks on your Laravel codebase

# Exit on error
set -e

echo "🔒 Running Laravel Security Check..."

# Target directories to check
DIRS_TO_CHECK="app config database routes resources"

# 1. Check for potentially dangerous PHP functions
echo "🔍 Checking for dangerous PHP functions..."
DANGEROUS_FUNCTIONS=(
  "shell_exec"
  "exec"
  "passthru"
  "system"
  "proc_open"
  "popen"
  "pcntl_exec"
  "eval"
  "assert"
  "create_function"
)

DANGEROUS_DB_COMMANDS=(
  "DROP DATABASE"
  "DROP TABLE"
  "TRUNCATE TABLE"
  "DELETE FROM"
)

# Get all PHP files
PHP_FILES=$(find $DIRS_TO_CHECK -name "*.php" -type f)

if [ -n "$PHP_FILES" ]; then
  # Check for dangerous functions in PHP files
  for FUNC in "${DANGEROUS_FUNCTIONS[@]}"; do
    MATCHES=$(grep -n "$FUNC" $PHP_FILES 2>/dev/null || echo "")
    if [ -n "$MATCHES" ]; then
      echo "⚠️  WARNING: Potentially dangerous PHP function '$FUNC' detected:"
      echo "$MATCHES"
      echo ""
    fi
  done

  # Check for dangerous database commands
  for CMD in "${DANGEROUS_DB_COMMANDS[@]}"; do
    MATCHES=$(grep -n "$CMD" $PHP_FILES 2>/dev/null || echo "")
    if [ -n "$MATCHES" ]; then
      echo "⚠️  WARNING: Potentially dangerous database command '$CMD' detected:"
      echo "$MATCHES"
      echo ""
    fi
  done
fi

# 2. Check for file deletion code
echo "🔍 Checking for file deletion code..."
FILE_DELETION_FUNCTIONS=(
  "unlink"
  "rmdir"
  "File::delete"
  "deleteDirectory"
  "Storage::delete"
)

for FUNC in "${FILE_DELETION_FUNCTIONS[@]}"; do
  MATCHES=$(grep -n "$FUNC" $PHP_FILES 2>/dev/null || echo "")
  if [ -n "$MATCHES" ]; then
    echo "⚠️  WARNING: File deletion function '$FUNC' detected:"
    echo "$MATCHES"
    echo ""
  fi
done

# 3. Check for secrets/credentials in code
echo "🔍 Checking for secrets or credentials in code..."
SECRETS_PATTERNS=(
  "password[\s]*=[\s]*['\"][^'\"]+['\"]"
  "api[\s]*key[\s]*=[\s]*['\"][^'\"]+['\"]"
  "secret[\s]*=[\s]*['\"][^'\"]+['\"]"
  "token[\s]*=[\s]*['\"][^'\"]+['\"]"
  "-----BEGIN PRIVATE KEY-----"
  "-----BEGIN RSA PRIVATE KEY-----"
  "AUTH_[A-Z0-9_]*=.+"
)

for PATTERN in "${SECRETS_PATTERNS[@]}"; do
  MATCHES=$(grep -n -E "$PATTERN" $PHP_FILES 2>/dev/null || echo "")
  if [ -n "$MATCHES" ]; then
    echo "⚠️  WARNING: Possible credentials or secrets found:"
    echo "$MATCHES"
    echo ""
  fi
done

# 4. Check for .env file in version control
if [ -f ".env" ] && [ ! -f ".gitignore" ] || ! grep -q "^\.env$" .gitignore; then
  echo "⚠️  WARNING: .env file might not be properly ignored in version control."
  echo "Please add .env to your .gitignore file."
  echo ""
fi

# 5. Run PHP syntax validation on all PHP files
echo "🔍 Validating PHP syntax..."
SYNTAX_ERRORS=0
for FILE in $PHP_FILES; do
  php -l "$FILE" > /dev/null || SYNTAX_ERRORS=$((SYNTAX_ERRORS+1))
done

if [ $SYNTAX_ERRORS -gt 0 ]; then
  echo "⚠️  WARNING: $SYNTAX_ERRORS PHP syntax errors found."
  echo ""
fi

# 6. Run code quality tools if available
if command -v ./vendor/bin/pint &> /dev/null; then
  echo "🔍 Running Laravel Pint in dry-run mode..."
  ./vendor/bin/pint --test
fi

if command -v ./vendor/bin/phpstan &> /dev/null; then
  echo "🔍 Running PHPStan..."
  ./vendor/bin/phpstan analyse --no-progress --level=5
fi

# 7. Check for dependency vulnerabilities
if command -v composer &> /dev/null; then
  echo "🔍 Checking for dependency vulnerabilities..."
  composer audit || echo "⚠️  WARNING: Security vulnerabilities found in dependencies."
fi

# 8. Check for potentially harmful scheduler tasks
echo "🔍 Checking for potentially harmful scheduler tasks..."
SCHEDULER_FILE="app/Console/Kernel.php"
if [ -f "$SCHEDULER_FILE" ]; then
  MATCHES=$(grep -n "DB::statement\|Artisan::call" "$SCHEDULER_FILE" 2>/dev/null || echo "")
  if [ -n "$MATCHES" ]; then
    echo "⚠️  WARNING: Potentially dangerous scheduler tasks detected:"
    echo "$MATCHES"
    echo ""
  fi
fi

echo "✅ Security check completed!" 