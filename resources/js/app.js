import './bootstrap';
import 'laravel-datatables-vite';
import Alpine from 'alpinejs';
import 'datatables.net-bs5';
import 'datatables.net-buttons-bs5';
import jszip from 'jszip';
import pdfMake from 'pdfmake/build/pdfmake';
import pdfFonts from 'pdfmake/build/vfs_fonts';

window.JSZip = jszip;
pdfMake.vfs = pdfFonts.pdfMake.vfs;
require('datatables.net-buttons/js/buttons.html5.js');
require('datatables.net-buttons/js/buttons.print.js');

window.Alpine = Alpine;


Alpine.start();
