const fs = require('fs');
const path = require('path');

const inputFile = path.join(__dirname, 'public/style_files/frontend/css/bc.bundle.css');
const outputFile = path.join(__dirname, 'public/style_files/frontend/css/bc.bundle.min.css');

// Read the CSS file
const css = fs.readFileSync(inputFile, 'utf8');

// Simple minification: remove comments and extra whitespace
const minified = css
  .replace(/\/\*[\s\S]*?\*\//g, '') // Remove comments
  .replace(/\s+/g, ' ') // Replace multiple spaces with single space
  .replace(/\s*([{}:;,])\s*/g, '$1') // Remove spaces around {}:;,
  .replace(/;\}/g, '}') // Remove last semicolon before }
  .trim();

// Write minified file
fs.writeFileSync(outputFile, minified, 'utf8');

// Calculate sizes
const originalSize = (fs.statSync(inputFile).size / 1024).toFixed(2);
const minifiedSize = (fs.statSync(outputFile).size / 1024).toFixed(2);
const savings = ((1 - minifiedSize / originalSize) * 100).toFixed(1);

console.log('✅ CSS Minification Complete!');
console.log(`📦 Original: ${originalSize} KB`);
console.log(`📦 Minified: ${minifiedSize} KB`);
console.log(`💾 Saved: ${savings}%`);
