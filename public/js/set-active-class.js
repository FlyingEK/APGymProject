function setActive(selector) {
    $(document).on('click', selector, function() {
        $(selector).removeClass('activeTab');
        $(this).addClass('activeTab');
    });
}  
setActive(".pgtab1 a");
setActive(".pgtab2 a");