$(document).ready(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    loadData()
});

function loadData() {

    $('input[name=other_agency]').hide()
    $('label[name=label_agency]').hide()
    $('input[name=other_agency]').attr('disabled','true');

    $('#datatable-crud').DataTable({
        processing: true,
        serverSide: true,
        scrollX: true,
        destroy: true,
        ajax: {
            url: "/kerjasamaAgensi",
            type: 'GET'
        },
        columns: [{
                data: 'DT_RowIndex'
            },
            {
                data: 'agency'
            },
            {
                data: 'collaboration_matters'
            },
            {
                data: 'collaboration_date'
            },
            {
                data: 'create_date'
            },
            {
                data: '',
                className: 'text-center'
            },
        ],
        columnDefs: [
            {
                "targets": 5,
                "data": "id",
                "render": function(data, type, row) {
                    var btn = 
                        '<a href="#" id="editData" data-id="' + row.id +'" data-toggle="modal" data-target="#updateModal" class="btn btn-warning btn-sm"><i class="fa fa-edit nav-icon"></i></a> '+
                        '<a href="#" id="deleteData" data-id="' + row.id +'" class="btn btn-danger btn-sm"><i class="fa fa-trash nav-icon"></i></a>'

                    return btn;
                }
            },
        ],
        order: [
            [0, 'asc']
        ]
    });
}

$(document).ready(function() {
    // Start Ajax Edit data
    $("body").on("click", "#editData", function(e) {
        if (!confirm("Do you really want to do this?")) {
            return false;
        }
        e.preventDefault();
        var id = $(this).data("id");
        var token = $("meta[name='csrf-token']").attr("content");
        var url = e.target;
        $.ajax({
            url: "/kerjasamaAgensi/edit/"+ id,
            type: 'GET',
            data: {},
            success: function(response) {
                $("#success").html(response.message)

                if (response.status) {
                    data = response.data

                    console.log('data result: '+ data.id_agency);
                    
                    var form = $('.form-update-data');
                    form.find('input[name=id]').val(data.id);
                    form.find('select[name=agency]').val(data.id_agency);
                    form.find('input[name=other_agency]').val(data.other_agency);
                    form.find('input[name=collaboration_matters]').val(data.collaboration_matters);
                    form.find('input[name=collaboration_date]').val(data.collaboration_date);

                    if(data.id_agency == 0) {
                        $('input[name=other_agency]').show()
                        $('label[name=label_agency]').show()
                        $('input[name=other_agency]').removeAttr("disabled");
                    } else {
                        $('input[name=other_agency]').hide()
                        $('label[name=label_agency]').hide()
                        $('input[name=other_agency]').attr('disabled','true');
                    }


                    $('#updateModal').modal('show');
                } else {
                }
            }
        });
        return false;
    });
    // End Ajax Edit data

    // Start Ajax Delete data
    $("body").on("click", "#deleteData", function(e) {
        if (!confirm("Do you really want to do this?")) {
            return false;
        }
        e.preventDefault();
        var id = $(this).data("id");
        var token = $("meta[name='csrf-token']").attr("content");
        $.ajax({
            url: "/kerjasamaAgensi/destroy/"+ id,
            type: 'DELETE',
            data: {},
            success: function(response) {

                if (response.status) {

                    loadData()
                    Swal.fire({
                        icon: "success",
                        title: 'Success!',
                        text: response.message,
                        showConfirmButton: true,
                    });

                } else {
                }
            }
        });
        return false;
    });
    // End Ajax Delete data

    $("body").on('submit', '.form-update-data', function(e){
        e.preventDefault();
        var form = $(this),  input_token = $('input[name=_token]'),
            id = form.find('input[name=id]').val();

        $.ajax({
            url: '/kerjasamaAgensi/update/'+id,
            type: "POST",
            data: {
                _token: input_token.val(),
                agency: form.find('select[name=agency]').val(),
                other_agency: form.find('input[name=other_agency]').val(),
                collaboration_matters: form.find('input[name=collaboration_matters]').val(),
                collaboration_date: form.find('input[name=collaboration_date]').val(),
            }
        })
        .done(function (result) {
            input_token.val(result.newToken)
            if (result.status) {
                $('#updateModal').modal('hide');

                loadData()
                Swal.fire({
                    icon: "success",
                    title: 'Success!',
                    text: result.message,
                    showConfirmButton: true,
                });
                
            } else {
            }
            input_token.val(result.newToken);
        })
    
    });

});

$('select[name=agency]').on('change', function() {

    var current_select = $(this).find(":selected").val();
 
    console.log('cs : '+ current_select);

    if(current_select == 0){
        $('input[name=other_agency]').show()
        $('label[name=label_agency]').show()
        $('input[name=other_agency]').removeAttr("disabled");

    } else {
        $('input[name=other_agency]').hide()
        $('label[name=label_agency]').hide()
        $('input[name=other_agency]').attr('disabled','true');

    }

});