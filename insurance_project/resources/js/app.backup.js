import './bootstrap';

// import '../../style_files/frontend/sass/main.scss'



import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();




import.meta.glob([
    '../../style_files/frontend/img**',
    '../../style_files/frontend/fonts**',
    '../../style_files/frontend/js**',
    '../../style_files/frontend/css**',
  ]);
// const http = require('http')
// const hostname = '78.46.167.62';
// const port = 5173;

// const server = http.createServer((req, res) => {
//   res.statusCode = 200;
//   res.setHeader('Content-Type', 'text/plain');
//   res.end('Hello World! NodeJS \n');
// });

// server.listen(port, hostname, () => {
//   console.log(`Server running at http://${hostname}:${port}/`);
// });