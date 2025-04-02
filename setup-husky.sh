#!/bin/bash
# Husky Setup Script for Laravel Project
# This script sets up Husky with the security pre-commit hook

# Initialize NPM if not already done
if [ ! -f "package.json" ]; then
    echo "Initializing NPM package.json..."
    npm init -y
fi

# Install Husky
echo "Installing Husky..."
npm install husky --save-dev

# Create Husky directory
mkdir -p .husky

# Set up Husky
echo "Setting up Husky..."
npx husky install

# Make pre-commit hook executable
chmod +x .husky/pre-commit

# Update package.json to include the prepare script
node -e "
const fs = require('fs');
const packageJson = JSON.parse(fs.readFileSync('./package.json'));
if (!packageJson.scripts) packageJson.scripts = {};
packageJson.scripts.prepare = 'husky install';
packageJson.scripts['security-check'] = './security-check.sh';
fs.writeFileSync('./package.json', JSON.stringify(packageJson, null, 2));
"

# Make security check script executable
chmod +x security-check.sh

echo "✅ Husky and security pre-commit hook setup complete!"
echo "The pre-commit hook will run automatically before each commit."
echo "You can run 'npm run security-check' manually to check your entire project." 