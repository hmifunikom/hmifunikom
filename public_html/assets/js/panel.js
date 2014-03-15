function generate_username() {
    var angkatan = $('#angkatan').val();
    var kelas = $('#kelas').val();

    $('#username').text('ifgames'+''+angkatan+''+kelas);
}

$(function(){
    $('.datepick').datepicker();
    
    $('.confirm-delete').submit(function(e) {
        var data = $(this).data('confirm');
        var message = ($(this).data('confirm-message')) ? $(this).data('confirm-message') : '';
        var conf = confirm('Anda yakin ingin menghapus ' + data + ' ini? ' + message);
        $('<input>').attr('type','hidden').attr("name", "safe-action").val("1").appendTo(this);
        if(conf) {
            return true;
        }
        e.preventDefault();
    });
    
    $('.js-tooltip').tooltip();

    var angkatan_slc = $('#angkatan');
    var kelas_slc = $('#kelas');
    if(angkatan_slc.length && kelas_slc.length) {
        angkatan_slc.on("change", function() {
            generate_username();
        });

        kelas_slc.on("change", function() {
            generate_username();
        });
    }
});