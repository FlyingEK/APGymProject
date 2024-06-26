function setActive(selector) {
    $(document).on('click', selector, function() {
        $(selector).removeClass('active');
        $(this).addClass('active');
    });
}  
setActive(".pgtabs a");