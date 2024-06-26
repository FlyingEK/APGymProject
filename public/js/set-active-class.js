function setActive(selector) {
    $(document).on('click', selector, function() {
        $(selector).removeClass('active');
        $(this).addClass('active');
    });
}  
setActive(".pgtab1 a");
setActive(".pgtab2 a");