// Please see documentation at https://learn.microsoft.com/aspnet/core/client-side/bundling-and-minification
// for details on configuring this project to bundle and minify static web assets.

// Write your JavaScript code.
// Initiate data table
$(document).ready(function () {

    $('.datatable').DataTable({
        "paging": true,
        "ordering": true,
        "info": true,
        "searching": true,
        "lengthChange": true,
        "autoWidth": true,
        "responsive": true
    });

    $('.mobileTable').DataTable({
        "paging": false,
        "lengthChange": false,
        "info": false,
        "autoWidth": true,
        "searching": true,
        "responsive": true
    });

    $('.pureDatatable').DataTable({
        "paging": false,
        "lengthChange": false,
        "info": false,
        "autoWidth": true,
        "searching": false,
        "responsive": true
    });

    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })
    
    $('.datepicker').flatpickr({
        altInput: true,
        dateFormat: "dd/mm/yyyy",
        allowInput: true,
    })
    
    
});



