#!/bin/bash
# Laravel Security Test Script
# This script performs comprehensive security checks on a Laravel project
# Usage: ./security-test.sh [path-to-project]

set -e

# Define project path
PROJECT_PATH=${1:-.}
cd "$PROJECT_PATH"

echo "🔒 Running Laravel Security Test Script on $(pwd)"
echo "================================================"

# Check if this is a Laravel project
if [ ! -f "artisan" ]; then
    echo "❌ Error: This doesn't appear to be a Laravel project."
    exit 1
fi

# 1. Static Analysis
echo "🔍 Running static analysis..."
echo "----------------------------"

# 1.1 Check for potentially dangerous PHP functions
echo "Checking for dangerous PHP functions..."
DANGEROUS_FUNCTIONS=(
    "shell_exec" "exec" "passthru" "system" "proc_open" "popen" "pcntl_exec"
    "eval" "assert" "create_function" "include_once" "require_once" 
    "exit" "die" "preg_replace.*\/e"
)

DANGEROUS_DB_COMMANDS=(
    "DROP DATABASE" "DROP TABLE" "TRUNCATE TABLE" "DELETE FROM"
)

FILE_DELETION_FUNCTIONS=(
    "unlink" "rmdir" "File::delete" "deleteDirectory" "Storage::delete"
)

# Get all PHP files excluding vendor and node_modules
PHP_FILES=$(find . -name "*.php" -not -path "./vendor/*" -not -path "./node_modules/*" -not -path "./storage/*")

# Check for dangerous functions
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

# Check for file deletion functions
for FUNC in "${FILE_DELETION_FUNCTIONS[@]}"; do
    MATCHES=$(grep -n "$FUNC" $PHP_FILES 2>/dev/null || echo "")
    if [ -n "$MATCHES" ]; then
        echo "⚠️  WARNING: File deletion function '$FUNC' detected:"
        echo "$MATCHES"
        echo ""
    fi
done

# 2. Check for sensitive information
echo "🔍 Checking for sensitive information..."
echo "--------------------------------------"

SECRETS_PATTERNS=(
    "password[\s]*=[\s]*['\"][^'\"]+['\"]"
    "api[\s]*key[\s]*=[\s]*['\"][^'\"]+['\"]"
    "secret[\s]*=[\s]*['\"][^'\"]+['\"]"
    "token[\s]*=[\s]*['\"][^'\"]+['\"]"
    "-----BEGIN PRIVATE KEY-----"
    "-----BEGIN RSA PRIVATE KEY-----"
    "AUTH_[A-Z0-9_]*=.+"
    "[a-zA-Z0-9_-]+\.[a-zA-Z0-9_-]+\.[a-zA-Z0-9_-]+" # JWT pattern
)

for PATTERN in "${SECRETS_PATTERNS[@]}"; do
    MATCHES=$(grep -n -E "$PATTERN" $PHP_FILES 2>/dev/null || echo "")
    if [ -n "$MATCHES" ]; then
        echo "⚠️  WARNING: Possible credentials or secrets found:"
        echo "$MATCHES"
        echo ""
    fi
done

# 3. Check for unsafe middleware
echo "🔍 Checking middleware..."
echo "----------------------"

MIDDLEWARE_FILES=$(find ./app/Http/Middleware -name "*.php" 2>/dev/null)
if [ -n "$MIDDLEWARE_FILES" ]; then
    DANGEROUS_MIDDLEWARE=$(grep -n "DB::statement\|Artisan::call\|exec\|shell_exec\|system" $MIDDLEWARE_FILES 2>/dev/null || echo "")
    if [ -n "$DANGEROUS_MIDDLEWARE" ]; then
        echo "⚠️  WARNING: Potentially dangerous code in middleware:"
        echo "$DANGEROUS_MIDDLEWARE"
        echo ""
    fi
fi

# 4. Check scheduler tasks
echo "🔍 Checking scheduler tasks..."
echo "---------------------------"

SCHEDULER_FILE="app/Console/Kernel.php"
if [ -f "$SCHEDULER_FILE" ]; then
    DANGEROUS_SCHEDULER=$(grep -n "DB::statement\|Artisan::call\|exec\|shell_exec\|system" "$SCHEDULER_FILE" 2>/dev/null || echo "")
    if [ -n "$DANGEROUS_SCHEDULER" ]; then
        echo "⚠️  WARNING: Potentially dangerous scheduler tasks:"
        echo "$DANGEROUS_SCHEDULER"
        echo ""
    fi
fi

# 5. Check for suspicious event listeners
echo "🔍 Checking event listeners..."
echo "---------------------------"

EVENT_LISTENER_PATH="app/Listeners"
if [ -d "$EVENT_LISTENER_PATH" ]; then
    DANGEROUS_LISTENERS=$(grep -n "DB::statement\|Artisan::call\|exec\|shell_exec\|system" $(find "$EVENT_LISTENER_PATH" -name "*.php") 2>/dev/null || echo "")
    if [ -n "$DANGEROUS_LISTENERS" ]; then
        echo "⚠️  WARNING: Potentially dangerous code in event listeners:"
        echo "$DANGEROUS_LISTENERS"
        echo ""
    fi
fi

# 6. Check for vulnerable dependencies
echo "🔍 Checking dependencies..."
echo "------------------------"

if command -v composer &> /dev/null; then
    echo "Running composer audit..."
    composer audit || echo "⚠️  WARNING: Security vulnerabilities found in dependencies."
else
    echo "⚠️  WARNING: Composer not found, skipping dependency check."
fi

# 7. Check Git history for suspicious commits
echo "🔍 Checking Git history..."
echo "-----------------------"

if [ -d ".git" ]; then
    echo "Checking for suspicious commits..."
    git log --all --grep="DROP DATABASE\|exec\|shell_exec\|system\|passthru\|unlink" --oneline || true
    
    echo "Checking for large file additions..."
    git log --all --stat --oneline | grep -B5 "1000 insertions" || true
else
    echo "⚠️  WARNING: Not a Git repository, skipping Git history check."
fi

# 8. Check Laravel config files
echo "🔍 Checking Laravel config files..."
echo "--------------------------------"

CONFIG_FILES=$(find ./config -name "*.php" 2>/dev/null)
DANGEROUS_CONFIG=$(grep -n "DB::statement\|Artisan::call\|exec\|shell_exec\|system" $CONFIG_FILES 2>/dev/null || echo "")
if [ -n "$DANGEROUS_CONFIG" ]; then
    echo "⚠️  WARNING: Potentially dangerous code in config files:"
    echo "$DANGEROUS_CONFIG"
    echo ""
fi

# 9. Check for unprotected routes
echo "🔍 Checking routes..."
echo "------------------"

ROUTE_FILES=$(find ./routes -name "*.php" 2>/dev/null)
UNPROTECTED_ROUTES=$(grep -n "Route::get\|Route::post\|Route::put\|Route::delete" $ROUTE_FILES | grep -v "middleware\|auth" 2>/dev/null || echo "")
if [ -n "$UNPROTECTED_ROUTES" ]; then
    echo "⚠️  WARNING: Potentially unprotected routes:"
    echo "$UNPROTECTED_ROUTES"
    echo ""
fi

# 10. Check for insecure file permissions
echo "🔍 Checking file permissions..."
echo "----------------------------"

# Check .env file
if [ -f ".env" ]; then
    ENV_PERMS=$(stat -c "%a" .env 2>/dev/null || stat -f "%OLp" .env 2>/dev/null)
    if [[ "$ENV_PERMS" != "600" && "$ENV_PERMS" != "400" ]]; then
        echo "⚠️  WARNING: .env file has potentially insecure permissions: $ENV_PERMS"
        echo "    Consider changing to 600 (chmod 600 .env)"
    fi
fi

# Check storage and bootstrap/cache directories
if [ -d "storage" ]; then
    STORAGE_PERMS=$(stat -c "%a" storage 2>/dev/null || stat -f "%OLp" storage 2>/dev/null)
    if [[ "$STORAGE_PERMS" != "755" && "$STORAGE_PERMS" != "750" ]]; then
        echo "⚠️  WARNING: storage directory has potentially insecure permissions: $STORAGE_PERMS"
        echo "    Consider changing to 755 (chmod 755 storage)"
    fi
fi

if [ -d "bootstrap/cache" ]; then
    CACHE_PERMS=$(stat -c "%a" bootstrap/cache 2>/dev/null || stat -f "%OLp" bootstrap/cache 2>/dev/null)
    if [[ "$CACHE_PERMS" != "755" && "$CACHE_PERMS" != "750" ]]; then
        echo "⚠️  WARNING: bootstrap/cache directory has potentially insecure permissions: $CACHE_PERMS"
        echo "    Consider changing to 755 (chmod 755 bootstrap/cache)"
    fi
fi

# 11. Check for proper environment configuration
echo "🔍 Checking environment configuration..."
echo "-------------------------------------"

if [ -f ".env" ]; then
    # Check for APP_DEBUG=true
    if grep -q "APP_DEBUG=true" .env; then
        echo "⚠️  WARNING: APP_DEBUG is set to true in .env"
        echo "    This should be false in production environments."
    fi
    
    # Check for APP_ENV=local
    if grep -q "APP_ENV=local" .env; then
        echo "⚠️  WARNING: APP_ENV is set to local in .env"
        echo "    This should be production in production environments."
    fi
    
    # Check for empty APP_KEY
    if grep -q "APP_KEY=$" .env; then
        echo "⚠️  WARNING: APP_KEY is empty in .env"
        echo "    Generate a key using: php artisan key:generate"
    fi
fi

# 12. Run PHP Code Sniffer if available
echo "🔍 Running code quality tools..."
echo "-----------------------------"

if command -v ./vendor/bin/phpcs &> /dev/null; then
    echo "Running PHP Code Sniffer..."
    ./vendor/bin/phpcs --standard=PSR12 app/ || echo "⚠️  WARNING: Code style issues found."
else
    echo "PHP Code Sniffer not found, skipping."
fi

# 13. Run PHPStan if available
if command -v ./vendor/bin/phpstan &> /dev/null; then
    echo "Running PHPStan..."
    ./vendor/bin/phpstan analyse --no-progress || echo "⚠️  WARNING: Static analysis issues found."
else
    echo "PHPStan not found, skipping."
fi

# 14. Run Laravel Pint if available
if command -v ./vendor/bin/pint &> /dev/null; then
    echo "Running Laravel Pint..."
    ./vendor/bin/pint --test || echo "⚠️  WARNING: Code style issues found."
else
    echo "Laravel Pint not found, skipping."
fi

# 15. Run Laravel Enlightn if available
if command -v ./vendor/bin/enlightn &> /dev/null; then
    echo "Running Laravel Enlightn..."
    php artisan enlightn --details || echo "⚠️  WARNING: Enlightn found issues."
else
    echo "Laravel Enlightn not found, skipping."
fi

echo "================================================================"
echo "✅ Security test completed! Review any warnings listed above."
echo "Remember: This script is a tool to help identify potential security issues,"
echo "but it's not a substitute for a thorough security audit by a professional." 