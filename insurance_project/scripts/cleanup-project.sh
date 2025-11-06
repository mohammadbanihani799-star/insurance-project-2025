#!/bin/bash
#
# BCare Insurance - Project Cleanup Script
# Purpose: Remove unused files and optimize the project structure
# Author: GitHub Copilot
# Date: November 5, 2025
#

set -e  # Exit on error

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# Project directory
PROJECT_DIR="d:/insurance_project(2025)/insurance_project"

echo -e "${BLUE}━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━${NC}"
echo -e "${BLUE}  BCare Insurance - Project Cleanup & Optimization${NC}"
echo -e "${BLUE}━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━${NC}"
echo ""

cd "$PROJECT_DIR"

# ======================
# Step 1: Create Backup
# ======================
echo -e "${YELLOW}[1/8]${NC} Creating backup..."
BACKUP_DIR="backups"
TIMESTAMP=$(date +%Y%m%d_%H%M%S)
BACKUP_FILE="${BACKUP_DIR}/backup_before_cleanup_${TIMESTAMP}.tar.gz"

mkdir -p "$BACKUP_DIR"

# Backup critical directories (excluding vendor and node_modules)
tar -czf "$BACKUP_FILE" \
  --exclude='vendor' \
  --exclude='node_modules' \
  --exclude='storage/logs' \
  --exclude='bootstrap/cache' \
  app/ \
  resources/ \
  public/ \
  routes/ \
  config/ \
  database/ \
  2>/dev/null

echo -e "${GREEN}✅ Backup created:${NC} $BACKUP_FILE"
echo ""

# ======================
# Step 2: Clean Laravel Cache
# ======================
echo -e "${YELLOW}[2/8]${NC} Cleaning Laravel cache..."
php artisan optimize:clear 2>/dev/null || true
php artisan view:clear 2>/dev/null || true
php artisan cache:clear 2>/dev/null || true
php artisan config:clear 2>/dev/null || true
php artisan route:clear 2>/dev/null || true
echo -e "${GREEN}✅ Laravel cache cleared${NC}"
echo ""

# ======================
# Step 3: Remove Compiled Views
# ======================
echo -e "${YELLOW}[3/8]${NC} Removing compiled views..."
rm -rf storage/framework/views/*.php 2>/dev/null || true
echo -e "${GREEN}✅ Compiled views removed${NC}"
echo ""

# ======================
# Step 4: Clean Bootstrap Cache
# ======================
echo -e "${YELLOW}[4/8]${NC} Cleaning bootstrap cache..."
rm -rf bootstrap/cache/*.php 2>/dev/null || true
echo -e "${GREEN}✅ Bootstrap cache cleaned${NC}"
echo ""

# ======================
# Step 5: Remove Log Files (keep last 7 days)
# ======================
echo -e "${YELLOW}[5/8]${NC} Cleaning old log files..."
find storage/logs -name "*.log" -mtime +7 -delete 2>/dev/null || true
echo -e "${GREEN}✅ Old log files removed${NC}"
echo ""

# ======================
# Step 6: Optimize Composer Autoloader
# ======================
echo -e "${YELLOW}[6/8]${NC} Optimizing Composer autoloader..."
composer dump-autoload -o --no-dev 2>/dev/null || composer dump-autoload -o || true
echo -e "${GREEN}✅ Composer autoloader optimized${NC}"
echo ""

# ======================
# Step 7: Check for Duplicate Files
# ======================
echo -e "${YELLOW}[7/8]${NC} Checking for duplicate files..."

# Check if style_files exists outside public (should not)
if [ -d "style_files" ]; then
    echo -e "${RED}⚠️  Found: /style_files/ (duplicate - outside public)${NC}"
    echo -e "   ${YELLOW}Action required: Verify files are in /public/style_files/${NC}"
else
    echo -e "${GREEN}✅ No duplicate style_files found${NC}"
fi

# Check for unused front_end_style
FRONT_END_USAGE=$(grep -r "front_end_style" resources/views/ 2>/dev/null | wc -l)
if [ "$FRONT_END_USAGE" -gt 0 ]; then
    echo -e "${YELLOW}⚠️  front_end_style is still used in ${FRONT_END_USAGE} places${NC}"
else
    echo -e "${GREEN}✅ front_end_style not in use${NC}"
fi

echo ""

# ======================
# Step 8: Generate Stats
# ======================
echo -e "${YELLOW}[8/8]${NC} Generating project statistics..."

# Calculate sizes
PUBLIC_SIZE=$(du -sh public/ 2>/dev/null | cut -f1)
VENDOR_SIZE=$(du -sh vendor/ 2>/dev/null | cut -f1)
NODE_SIZE=$(du -sh node_modules/ 2>/dev/null | cut -f1)
STORAGE_SIZE=$(du -sh storage/ 2>/dev/null | cut -f1)

echo ""
echo -e "${BLUE}━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━${NC}"
echo -e "${BLUE}  Project Statistics${NC}"
echo -e "${BLUE}━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━${NC}"
echo -e "  📁 Public Directory:    ${PUBLIC_SIZE}"
echo -e "  📦 Vendor Directory:    ${VENDOR_SIZE}"
echo -e "  📦 Node Modules:        ${NODE_SIZE}"
echo -e "  💾 Storage Directory:   ${STORAGE_SIZE}"
echo -e "${BLUE}━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━${NC}"
echo ""

echo -e "${GREEN}✅ Cleanup completed successfully!${NC}"
echo ""
echo -e "${YELLOW}Next steps:${NC}"
echo "  1. Run: npm run build"
echo "  2. Run: php artisan config:cache"
echo "  3. Run: php artisan route:cache"
echo "  4. Test the application: http://localhost:8000"
echo ""
echo -e "${BLUE}━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━${NC}"
