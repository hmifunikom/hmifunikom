$(function(){
    $('.datepick').datepicker();
    $('.confirm-delete').submit(function(e) {
        var data = $(this).data('confirm');
        var message = ($(this).data('confirm-message')) ? $(this).data('confirm-message') : '';
        var conf = confirm('Anda yakin ingin menghapus ' + data + ' ini? ' + message);
        if(conf) return true;
        e.preventDefault();
    });
});