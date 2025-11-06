#!/usr/bin/env node
/*
  Sync BCare CSS from source (style_files/frontend/css) to public path to avoid drift.
  Copies a small allowlist of critical files used by layouts/top.blade.php.
*/
const fs = require('fs');
const path = require('path');

const projectRoot = __dirname ? path.resolve(__dirname, '..') : process.cwd();
const srcDir = path.join(projectRoot, 'style_files', 'frontend', 'css');
const destDir = path.join(projectRoot, 'public', 'style_files', 'frontend', 'css');

const files = [
  'bcare-core.css',
  'bcare-components.css'
];

function ensureDir(dir) {
  if (!fs.existsSync(dir)) {
    fs.mkdirSync(dir, { recursive: true });
  }
}

function copyFile(src, dest) {
  try {
    fs.copyFileSync(src, dest);
    console.log(`Synced: ${path.relative(projectRoot, dest)}`);
  } catch (err) {
    console.warn(`Warn: Failed to copy ${src} -> ${dest}: ${err.message}`);
  }
}

function main() {
  ensureDir(destDir);
  let copied = 0;
  files.forEach((name) => {
    const srcPath = path.join(srcDir, name);
    const destPath = path.join(destDir, name);
    if (fs.existsSync(srcPath)) {
      copyFile(srcPath, destPath);
      copied++;
    } else {
      console.warn(`Warn: Source missing: ${path.relative(projectRoot, srcPath)}`);
    }
  });
  if (copied === 0) {
    console.warn('BCare CSS sync: no files copied. Check source directory and filenames.');
  }
}

main();
