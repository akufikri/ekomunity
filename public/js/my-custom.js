

$(".add-more").click(function(){ 
    var html = $(".copy").html();
    $(".after-add-more").after(html);
});

// saat tombol remove dklik control group akan dihapus 
$("body").on("click",".remove",function(){ 
    $(this).parents(".control-group").remove();
});

var e_modal_wait = $("#modalWait");
setTimeout(function () {
    e_modal_wait = $("#modalWait");
}, 5000)

function showLoading(e_modal) {
    e_modal_wait = e_modal || e_modal_wait;
    if (typeof (e_modal_wait) === 'undefined') return;
    if(typeof(e_modal_wait.modal) === 'function') {
        e_modal_wait.modal({backdrop: 'static', keyboard: false});
    }
}

function hideLoading(e_modal) {
    e_modal_wait = e_modal || e_modal_wait;
    if (typeof (e_modal_wait) === 'undefined') return;
    if(typeof(e_modal_wait.modal) === 'function') {
        e_modal_wait.modal('hide');
    }
    hideModal(e_modal_wait);
}

function hideModal(e_modal) {
    e_modal.removeClass("in");
    if ($(".modal-backdrop").length > 0) $(".modal-backdrop").remove();
    if ($('body').length > 0) $('body').removeClass('modal-open');
    if ($('body').length > 0) $('body').css('padding-right', '');
    e_modal.hide();
}