import 'bootstrap/dist/css/bootstrap.min.css';  // Import Bootstrap CSS secara global
import 'bootstrap/dist/js/bootstrap.bundle.min.js'; // Import Bootstrap JS bundle (Popper termasuk)

import Alpine from 'alpinejs';  // Alpine.js untuk interaktivitas
window.Alpine = Alpine;
Alpine.start();

// Pastikan jQuery sudah dimuat dengan benar
import $ from 'jquery';

$(document).ready(function () {
    // Event untuk membuka modal tambah data
    $('#addModal').on('shown.bs.modal', function () {
        $(this).find('input:first').focus();
    });

    // Event untuk modal edit data (menggunakan delegasi event)
    $('body').on('shown.bs.modal', '.modal', function () {
        $(this).find('input:first').focus();
    });
});
