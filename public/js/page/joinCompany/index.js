$(document).ready( function () {
    $.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    
    loadData()
    loadDataTemp()
});

function loadData(){

    var id_level = $('input[name=id_level]').val()
    var id_user = $('input[name=id]').val()

    console.log('id_level: '+id_level);
    console.log('id_user: '+id_user);



    const queryString = window.location.search;
    console.log(queryString);

    $('#datatable-crud').DataTable({
        processing: true,
        serverSide: true,
        destroy: true,
        scrollX: true,
        ajax: {
                url: "/log_pendaftar_persatuan"+queryString,
                type: 'GET'
            },

        columns: [
            { data: 'DT_RowIndex' },
            { data: 'manpower.user.fullname' },
            { data: 'company.full_company_name' },
            { data: 'manpower.ic_number' },
            { data: 'manpower.city.city' },
            { data: 'create_date' },
            { data: 'status_approval' },
            { data: 'status_approval_date' },
            { data: 'payment_method' },
            { data: 'id', className: 'text-center' },
        ],
        columnDefs: [
                {
                    "targets" : 6,
                    "data": "status_approval",
                    "render" : function (data, type, row) {
                        var btn = '<div><button class=" btn btn-sm btn-warning" style="width:100%">Waiting</button></div>'
                        if(row.status_approval == "APPROVED") {
                            btn = '<div><button class=" btn btn-sm btn-success" style="width:100%">Approved</button></div>'
                        } else if (row.status_approval == "REJECTED") {
                            btn = '<div><button class=" btn btn-sm btn-danger" style="width:100%">Rejected</button></div>'
                        }
                        return btn;
                    }
                },
                {
                    "targets" : 8,
                    "data": "payment_method",
                    "render" : function (data, type, row) {//class="btn btn-primary btn-sm"
                        if(row.payment != null){
                            if(row.payment.approval == "REJECTED")
                                return '<div><button class=" btn btn-sm btn-danger" style="width:100%">Rejected</button></div>'
                            else
                                return (row.status_approval != "APPROVED") ? "-" : row.payment_method;
                        }
                        else
                            return (row.status_approval != "APPROVED") ? "-" : row.payment_method;
                    }
                },
                {
                    "targets" : 9,
                    "data": "id",
                    "render" : function (data, type, row) {//class="btn btn-primary btn-sm"
                        if(row.status_approval == "WAITING") {   
                            if(id_level != 3 && row.created_by != id_user){ 
                                return btn = '<a href="" id="detailApproval" data-id="'+row.manpower.user.id+'"  data-toggle="modal" data-target="#detailApprovalModal" class="btn btn-info btn-sm" >Respon</a>';
                            } else {
                                if(row.created_by != id_user){
                                    return btn = '<a href="/approval_jemput_ahli/'+row.id+'" class="btn btn-info btn-sm">Respon</a>';
                                }
                                return '-';
                            }
                        } else if (row.status_approval == "APPROVED") {

                            if(id_level == 3){
                                if (row.payment_date == null)
                                    return btn = '<a href="/invoice_join_persatuan/'+row.encrypt+'" target="_blank" class="btn btn-info btn-sm">Bayar</a>';
                                else {
                                    if(row.payment != null) {
                                        if(row.payment.approval == "REJECTED")
                                            return btn = '<a href="/invoice_join_persatuan/'+row.encrypt+'" target="_blank" class="btn btn-info btn-sm">Bayar Ulang</a>';
                                        else
                                            return '-'
                                    } else {
                                        return '-'
                                    }
                                }
                                    
                            } else if(id_level == 2) {
                                if (row.payment_date == null)
                                    return btn = '<a href="" id="payment" data-id="'+row.id+'" class="btn btn-info btn-sm">Bayar Cash</a>';
                                else 
                                    return '-' 
                            } else {
                                return '-'
                            }

                        } else {
                            return '-'
                        }
                    }
                },
            ],
        order: [[0, 'asc']]
    });
    
    }

    $("body").on("click","#detailApproval",function(e){
 
        e.preventDefault();

        var e_modal_wait = $("#modalWait");
        showLoading(e_modal_wait);

        var id = $(this).data("id");
        var token = $("meta[name='csrf-token']").attr("content");
        var url = e.target;
        $.ajax(
        {
            url: "/profilDigital?id_user="+id+"&api=true",
            type: 'GET',
            data: {},
            success: function (response){

                hideLoading(e_modal_wait);

                $("#success").html(response.message)

                var data = response

                console.log(data)

                var view = $('.content-data')

                var set_data =  '<div id="cardnew" class="cardnew" style="">'+
                                '<input type="hidden" id="id_request_join" name="id_request_join" value="'+data.request_join.id+'" placeholder="id">'+
                                '     <div class="fl">'+
                                '         <img class="img-circle" src="/Profil/'+data.user.photo+'" width="60px" height="60px" alt="Photo">'+
                                '     </div>'+
                                '     <div class="fl ml-20">'+
                                '         <div><p style="margin: 0px; margin-left:15px; font-size:14px;"><b>'+data.user.fullname+'</b></p></div>'+
                                '         <div class="" style="width:250px; margin-top:8px;">'+
                                '             <div class="fl ml-10"><img src="/CompanyLogo/'+data.picture_of_business+'" width="15px" alt="Logo"></div>'+
                                '             <p style="margin:0px; font-size:12px;color:gray; text-align:justify;">'+data.name_of_business+'</p>'+
                                '         </div>'+
                                '         <div class="" style="margin-top:12px;">'+
                                '             <div class="fl ml-10"><img src="/images/digitalprofile/location.png" width="15px" alt="Logo"></div>'+
                                '             <p style="margin:0px;max-width:250px;font-size:12px;color:gray; float:left; text-align:justify;">'+data.business_address+'</p>'+
                                '         </div>'+
                                '     </div>'+
                                '     <div class="fr" style="text-align: right;">'+
                                '         <div style="width: 100%">'+
                                '         </div>'+
                                '         <div style="width: 100%; text-align: -webkit-right;">'+
                                '         </div>'+
                                '     '+
                                '     </div>'+
                                '     <div class="fr mt-40" style="width:100%;">'+
                                '         <p style="margin:0px; font-size:12px;"><b>Maklumat Perhubungan</b></p>'+
                                '     </div>'+
                                '     <div class="fr sub-cardnew">'+
                                '         <div class="fl ml-10"><img src="/images/digitalprofile/phone.png" width="15px" alt="Logo"></div>'+
                                '         <p style="margin-top:5px; margin-left:10px; font-size:12px; width:200px; float:left">'+data.business_phone+'</p>'+
                                '         <div class="fl ml-10" style="float: right"><a target="_blank" href="https://wa.me/'+data.business_phone+'"><img src="/images/digitalprofile/wa.png" width="20px" alt="Whatsapp"></a></div>'+
                                '     </div>'+
                                '     <div class="fr sub-cardnew">'+
                                '         <div class="fl ml-10"><img src="/images/digitalprofile/email.png" width="20px" alt="Logo"></div>'+
                                '         <p id="myText" style="margin-top:5px; margin-left:12px; font-size:12px; width:200px; float:left">'+data.business_email+'</p>'+
                                '         <div class="fl ml-10" style="float: right"><a onclick="copyContent()"><img src="/images/digitalprofile/copy.png" width="20px" alt="Copy"></a></div>'+
                                '     </div>'+
                                '     <div class="fr sub-cardnew">'+
                                '         <div class="fl ml-10"><img src="/images/digitalprofile/id-card.png" width="20px" alt="Logo"></div>'+
                                '         <p id="myText" style="margin-top:5px; margin-left:12px; font-size:12px; width:200px; float:left">'+data.ic_number+'</p>'+
                                '         <div class="fl ml-10" style="float: right"><a onclick="copyContent()"><img src="/images/digitalprofile/copy.png" width="20px" alt="Copy"></a></div>'+
                                '     </div>'+
                                '     <div class="fr mt-40" style="width:100%;">'+
                                '         <p style="margin:0px;"><b>Perniagaan</b></p>'+
                                '     </div>'+
                                '     <div class="fr sub-cardnew">'+
                                '         <div class="fl ml-10"><img src="/images/digitalprofile/product.png" width="20px" alt="Logo"></div>'+
                                '         <p style="margin-top:5px; margin-left:10px; font-size:12px; width:200px; float:left">Produk</p>'+
                                '         <div class="fl ml-10" style="float: right"><a target="_blank" href="{{env(ECOMMERCE_URL)}}/company?code='+data.company_code+'"><img src="/images/digitalprofile/right.png" width="20px" alt="Arrow Right"></a></div>'+
                                '     </div>'+
                                ' </div>'

                view.html(set_data)
                
                var form = $('.form-detail-data')
                form.find('input[name="approval_note"]').val(data.note)
                form.find('input[name="approval"]').val(data.status)

                $('#detailApprovalModal').modal('show');
                
            }
        });
        return false;
    });

    $(document).on('click', '#approve_join', function(e){
            e.preventDefault();

            var e_modal_wait = $("#modalWait");
            showLoading(e_modal_wait);
            
            var id = $('input[name=id_request_join]').val()
                    
            $.ajax({
                url: 'approve_join/'+id,
                type: "GET",
                data: {}
            })
            .done(function (result) {
                // var message = result.message;
                hideLoading(e_modal_wait);
                if (result.isSuccess) {
                    $('#detailApprovalModal').modal('hide');
                    // initData(param)
                    // successAlert(message);
                    
                    loadData()
                    swal(
                        'Success!',
                        result.message,
                        'success'
                    )
                    
                    
                } else {
                    alert(result.message)
                }
                input_token.val(result.newToken);
            })
            .fail(function(xhr, error) {

            });
            
    });

    $(document).on('click', '#reject_join', function(e){
            e.preventDefault();

            var e_modal_wait = $("#modalWait");
            showLoading(e_modal_wait);
            
            var id = $('input[name=id_request_join]').val()
                    
            $.ajax({
                url: 'reject_join/'+id,
                type: "GET",
                data: {}
            })
            .done(function (result) {
                // var message = result.message;
                hideLoading(e_modal_wait);
                if (result.isSuccess) {
                    $('#detailApprovalModal').modal('hide');
                    // initData(param)
                    // successAlert(message);
                    
                    loadData()
                    swal(
                        'Success!',
                        result.message,
                        'success'
                    )
                    
                    
                } else {
                    alert(result.message)
                }
                input_token.val(result.newToken);
            })
            .fail(function(xhr, error) {

            });
            
    });

    $(document).on('click', '#payment', function(e){
        e.preventDefault();

        var e_modal_wait = $("#modalWait");
        showLoading(e_modal_wait);
        
        var id = $(this).data("id");
                
        $.ajax({
            url: '/payment_cash?id='+id+'&auto_approve=true',
            type: "GET",
            data: {}
        })
        .done(function (result) {

            hideLoading(e_modal_wait);

            if (result.isSuccess) {
                
                loadData()
                swal(
                    'Success!',
                    result.message,
                    'success'
                )
                   
            } else {
                loadData()
                swal(
                    'Failed!',
                    result.message,
                    'error'
                )
            }

        })
        .fail(function(xhr, error) {

        });
        
    });

    $(document).on('submit', '.form-approval-data', function(e){
            e.preventDefault();

            var e_modal_wait = $("#modalWait");
            showLoading(e_modal_wait);

            var ini = $(this),  input_token = $('input[name=_token]'),
                id = ini.find('input[name=id_log_certificate]').val(),
                url = '/approvalCertificate';
            var post_data = {
                is_ajax: true,
                _token: input_token.val(),
                id_log_certificate: ini.find('input[name=id_log_certificate]').val(),
                approval: ini.find('select[name=approval]').val(),
                approval_note: ini.find('textarea[name=approval_note]').val(),
            };
            
            // var e_modal_wait = $("#modalWait");
            // showLoading(e_modal_wait);
        
            $.ajax({
                url: url,
                type: "POST",
                data: post_data
            })
            .done(function (result) {
                // var message = result.message;
                hideLoading(e_modal_wait);
                if (result.data != null) {
                    $('#approvalModal').modal('hide');
                    // initData(param)
                    // successAlert(message);
                    
                    loadData()
                    swal(
                        'Success!',
                        'Approval Successfully!',
                        'success'
                    )

                    // setTimeout(
                    // function() 
                    // {
                    //     document.location.href = "/logCertificate?status=Approved"
                    // }, 3000);
                    
                    
                } else {
                    // failedAlert(message);
                }
                input_token.val(result.newToken);
            })
            .fail(function(xhr, error) {

            });
            
        });


$('#price').on('refresh load propertychange change click keyup input paste',(function (event) {
    $(this).val(function (index, value) {
        s= '' + value.replace(/(?!\.)\D/g, "").replace(/(?<=\..*)\./g, "").replace(/(?<=\.\d\d).*/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
      return  s;
    });
}));
$('#price1').on('refresh load propertychange change click keyup input paste',(function (event) {
    $(this).val(function (index, value) {
        s= '' + value.replace(/(?!\.)\D/g, "").replace(/(?<=\..*)\./g, "").replace(/(?<=\.\d\d).*/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
      return  s;
    });
}));