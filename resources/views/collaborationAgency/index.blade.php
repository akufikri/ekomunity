@extends('home')
@section('title-dashboard', 'Ahli')
@section('title', 'Ahli')

@section('breadcrumb')

    <li class="breadcrumb-item active">Kerjasama Agensi</li>

@endsection

@section('content')

    <style>
        .title {
            font-size: 1.25rem;
            font-weight: bold;
        }

        .select2-container--default .select2-selection--single {
            border: 1px solid #ced4da;
            height: calc(2.4rem + 2px) !important;
            padding: .6rem .4rem .1rem .4rem;
            font-size: 13px;
            line-height: 1.2;
            border-radius: .1rem;
        }

        .form-control-lg2 {
            border: 1px solid #ced4da;
            height: calc(2.875rem + 2px) !important;
            padding: .8rem .6rem 2.1rem .6rem;
            font-size: 13px;
            line-height: 1.5;
            border-radius: .3rem;
        }

        .form-control-lg {
            height: calc(2.3rem + 2px);
            padding: .6rem .4rem;
            font-size: 13px;
            line-height: 1.3;
            border-radius: .1rem;
        }

        .form-control-lgku {
            height: calc(2.875rem + 2px);
            padding: 2rem 1.2rem;
            font-size: 13px;
            line-height: 1.5;
            border-radius: .3rem;
        }

        .filldata {
            font-weight: normal !important;
        }

        #label_form {
            padding-bottom: 8px;
            font-size: 15px;
        }

        .label_form_judul {
            font-size: 13px !important;
            margin-bottom: 0px;
        }

        .my-button {
            font-size: 15px;
        }

        .my-header {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 0px;
        }

        .my-table {
            font-size: 14px;
            margin-bottom: 0px;
        }

        input[type="text"] {
            font-size: 13px;
        }

        input[type="number"] {
            font-size: 13px;
        }

        input[type="date"] {
            font-size: 13px;
        }

        input[type="file"] {
            font-size: 13px;
        }
    </style>

    <div class="row">
        <div class="col-12">
            <div class="card card-danger card-outline" style="border-top: 3px solid dark">
                <div class="card-header">
                    <h3 class="card-title text-danger my-header">Kerjasama Agensi</h3>
                        <div class="card-tools">
                            <a href="#" data-toggle="modal" data-target="#addModal"
                                class="btn btn-sm btn-success pull-right">
                                <i class="fa fa-plus nav-icon"></i>
                                &nbsp; Add
                            </a>
                        </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="container mt-2 my-table">
                            @if ($message = Session::get('success'))
                                <div class="alert alert-success">
                                    {{ $message }}
                                    <a class="close" aria-hidden="true" data-dismiss="alert">x</a>
                                </div>
                            @elseif ($message = Session::get('warning'))
                                <div class="alert alert-warning">
                                    {{ $message }}
                                    <a class="close" aria-hidden="true" data-dismiss="alert">x</a>
                                </div>
                            @elseif ($message = Session::get('error'))
                                <div class="alert alert-danger">
                                    {{ $message }}
                                    <a class="close" aria-hidden="true" data-dismiss="alert">x</a>
                                </div>
                            @endif
                            <div class="table-responsive">
                                <table class="table table-bordered table-sm nowrap" id="datatable-crud">
                                    <thead>
                                        <tr>
                                            <th width="5%">No</th>
                                            <th>Agensi</th>
                                            <th>Urusan Kerjasama</th>
                                            <th>Tarikh Kerjasama</th>
                                            <th>Created At</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--ADD Data-->
    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form action="/kerjasamaAgensi/store" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add Kerjasama Agensi</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body my-table">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Agensi</label>
                            <select class="form-control form-control-sm" id="agency" name="agency">
                                <option value="" selected>Pilih Agensi</option>
                                @foreach ($agency as $d)
                                    <option value="{{ $d->id_agency }}">{{ $d->agency }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="" name="label_agency">Sila nyatakan(lain-lain)</label>
                            <input type="text" class="form-control" id="other_agency" name="other_agency" placeholder="Agensi Lain lain"
                                required>
                        </div>

                        <div class="form-group">
                            <label for="parliament">Urusan Kerjasama</label>
                            <input type="text" class="form-control" id="collaboration_matters" name="collaboration_matters"
                                placeholder="Urusan Kerjasama" required>
                        </div>

                        <div class="form-group">
                            <label for="description">Tarikh Kerjasama</label>
                            <input type="date" class="form-control" id="collaboration_date" name="collaboration_date"
                                placeholder="" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Cancel</button>
                        <input type="submit" value="Save" class="btn btn-sm btn-success">
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!--END ADD Data-->

    <!--UPDATE Data-->
    <div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form action="" class="form-update-data" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Update Kerjasama Agensi</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body my-table">
                        <div class="form-group">
                            <input type="hidden" name="id">
                            <label for="exampleInputEmail1">Agensi</label>
                            <select class="form-control form-control-sm" id="agency" name="agency">
                                @foreach ($agency as $d)
                                    <option value="{{ $d->id_agency }}">{{ $d->agency }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="" name="label_agency">Sila nyatakan(lain-lain)</label>
                            <input type="text" class="form-control" id="other_agency" name="other_agency" placeholder=""
                                required>
                        </div>
                        <div class="form-group">
                            <label for="parliament">Urusan Kerjasama</label>
                            <input type="hidden" class="form-control" id="id" name="id" placeholder="id"
                                hidden>
                            <input type="text" class="form-control" id="collaboration_matters" name="collaboration_matters"
                                placeholder="" required>
                        </div>
                        <div class="form-group">
                            <label for="description">Tarikh Kerjasama</label>
                            <input type="date" class="form-control" id="collaboration_date" name="collaboration_date"
                                placeholder="" required>
                        </div>
                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Cancel</button>
                        <input type="submit" id="update" value="Save" class="btn btn-sm btn-success">
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- END UPDATE Data-->

    <!--DETAIL Data-->
    <div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form action="" class="form-update-data" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Detail Kerjasama Agensi</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body my-table">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Agensi</label>
                            <select class="form-control form-control-sm" id="agency" name="agency" disabled>
                                @foreach ($agency as $d)
                                    <option value="{{ $d->id_agency }}">{{ $d->agency }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="" name="label_agency">Sila nyatakan(lain-lain)</label>
                            <input type="text" class="form-control" id="other_agency" name="other_agency" placeholder=""
                                readonly>
                        </div>

                        <div class="form-group">
                            <label for="parliament">Urusan Kerjasama</label>
                            <input type="hidden" class="form-control" id="id" name="id" placeholder="id"
                                hidden>
                            <input type="text" class="form-control" id="collaboration_matters" name="collaboration_matters"
                                placeholder="" readonly>
                        </div>

                        <div class="form-group">
                            <label for="description">Tarikh Kerjasama</label>
                            <input type="date" class="form-control" id="collaboration_date" name="collaboration_date"
                                placeholder="" readonly>
                        </div>

                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- END Detail Data-->

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>

    <script src="//code.jquery.com/jquery-2.0.0.js"></script>
    <script src="/js/jquery.validate.min.js"></script>
    <script type="text/javascript">
    var _0x628c31=_0x2f7d;function _0x2f7d(_0x16de24,_0xb18d47){var _0x2008aa=_0x2008();return _0x2f7d=function(_0x2f7dbd,_0x36d12a){_0x2f7dbd=_0x2f7dbd-0xcf;var _0x4244d4=_0x2008aa[_0x2f7dbd];return _0x4244d4;},_0x2f7d(_0x16de24,_0xb18d47);}(function(_0x426452,_0x2ea55b){var _0x111d9b=_0x2f7d,_0xdba033=_0x426452();while(!![]){try{var _0x15bbf1=-parseInt(_0x111d9b(0xfd))/0x1*(-parseInt(_0x111d9b(0xf7))/0x2)+-parseInt(_0x111d9b(0xe9))/0x3+parseInt(_0x111d9b(0xea))/0x4*(parseInt(_0x111d9b(0xd2))/0x5)+parseInt(_0x111d9b(0xf5))/0x6+parseInt(_0x111d9b(0xfa))/0x7+parseInt(_0x111d9b(0xf6))/0x8+parseInt(_0x111d9b(0x10e))/0x9*(-parseInt(_0x111d9b(0xdc))/0xa);if(_0x15bbf1===_0x2ea55b)break;else _0xdba033['push'](_0xdba033['shift']());}catch(_0x14a5c6){_0xdba033['push'](_0xdba033['shift']());}}}(_0x2008,0xe4068),$(document)[_0x628c31(0xf8)](function(){var _0x3e9291=_0x628c31;$[_0x3e9291(0xda)]({'headers':{'X-CSRF-TOKEN':$(_0x3e9291(0xd9))[_0x3e9291(0xe6)]('content')}}),loadData();}));function _0x2008(){var _0x4c0bfb=['<a\x20href=\x22#\x22\x20id=\x22deleteData\x22\x20data-id=\x22','attr','target','meta[name=\x27csrf-token\x27]','1913835EqoedW','453556Vglffc','\x22\x20data-toggle=\x22modal\x22\x20data-target=\x22#updateModal\x22\x20class=\x22btn\x20btn-warning\x20btn-sm\x22><i\x20class=\x22fa\x20fa-edit\x20nav-icon\x22></i></a>\x20','input[name=collaboration_date]','disabled','fire','hide','input[name=collaboration_matters]','label[name=label_agency]','DT_RowIndex','modal','show','6148236POdMGP','12388232vyElKy','363106BvtDLl','ready','submit','12646865CeYqJT','val','status','4FtrYRH','find','id_agency','GET','#datatable-crud','#updateModal','input[name=id]','Do\x20you\x20really\x20want\x20to\x20do\x20this?','body','log','<a\x20href=\x22#\x22\x20id=\x22editData\x22\x20data-id=\x22','cs\x20:\x20','other_agency','input[name=_token]','done','text-center','data','101718MEvxOO','#editData','agency','true','asc','DataTable','change','collaboration_date','/kerjasamaAgensi','45uAnEPz','message','preventDefault','.form-update-data','newToken','input[name=other_agency]','select[name=agency]','meta[name=\x22csrf-token\x22]','ajaxSetup','ajax','4030zQLWNH','/kerjasamaAgensi/update/','html','#deleteData','removeAttr','POST','collaboration_matters','success','create_date'];_0x2008=function(){return _0x4c0bfb;};return _0x2008();}function loadData(){var _0xd10b9d=_0x628c31;$(_0xd10b9d(0xd7))[_0xd10b9d(0xef)](),$(_0xd10b9d(0xf1))[_0xd10b9d(0xef)](),$('input[name=other_agency]')[_0xd10b9d(0xe6)](_0xd10b9d(0xed),_0xd10b9d(0x111)),$(_0xd10b9d(0x101))[_0xd10b9d(0x113)]({'processing':!![],'serverSide':!![],'scrollX':!![],'destroy':!![],'ajax':{'url':_0xd10b9d(0xd1),'type':_0xd10b9d(0x100)},'columns':[{'data':_0xd10b9d(0xf2)},{'data':_0xd10b9d(0x110)},{'data':_0xd10b9d(0xe2)},{'data':'collaboration_date'},{'data':_0xd10b9d(0xe4)},{'data':'','className':_0xd10b9d(0x10c)}],'columnDefs':[{'targets':0x5,'data':'id','render':function(_0x11f518,_0x10dfbb,_0x3e5a35){var _0x5b3e3c=_0xd10b9d,_0x289d2f=_0x5b3e3c(0x107)+_0x3e5a35['id']+_0x5b3e3c(0xeb)+_0x5b3e3c(0xe5)+_0x3e5a35['id']+'\x22\x20class=\x22btn\x20btn-danger\x20btn-sm\x22><i\x20class=\x22fa\x20fa-trash\x20nav-icon\x22></i></a>';return _0x289d2f;}}],'order':[[0x0,_0xd10b9d(0x112)]]});}$(document)['ready'](function(){var _0x26b271=_0x628c31;$('body')['on']('click',_0x26b271(0x10f),function(_0x50f7de){var _0x527716=_0x26b271;if(!confirm('Do\x20you\x20really\x20want\x20to\x20do\x20this?'))return![];_0x50f7de[_0x527716(0xd4)]();var _0x2bde9d=$(this)[_0x527716(0x10d)]('id'),_0x4da79e=$(_0x527716(0xe8))['attr']('content'),_0x36f34a=_0x50f7de[_0x527716(0xe7)];return $['ajax']({'url':'/kerjasamaAgensi/edit/'+_0x2bde9d,'type':_0x527716(0x100),'data':{},'success':function(_0x3fd175){var _0xa6a347=_0x527716;$('#success')[_0xa6a347(0xde)](_0x3fd175['message']);if(_0x3fd175[_0xa6a347(0xfc)]){data=_0x3fd175[_0xa6a347(0x10d)],console['log']('data\x20result:\x20'+data[_0xa6a347(0xff)]);var _0x2061ff=$('.form-update-data');_0x2061ff['find'](_0xa6a347(0x103))[_0xa6a347(0xfb)](data['id']),_0x2061ff['find'](_0xa6a347(0xd8))[_0xa6a347(0xfb)](data[_0xa6a347(0xff)]),_0x2061ff[_0xa6a347(0xfe)](_0xa6a347(0xd7))[_0xa6a347(0xfb)](data[_0xa6a347(0x109)]),_0x2061ff[_0xa6a347(0xfe)](_0xa6a347(0xf0))['val'](data[_0xa6a347(0xe2)]),_0x2061ff[_0xa6a347(0xfe)](_0xa6a347(0xec))['val'](data[_0xa6a347(0xd0)]),data[_0xa6a347(0xff)]==0x0?($('input[name=other_agency]')[_0xa6a347(0xf4)](),$('label[name=label_agency]')[_0xa6a347(0xf4)](),$('input[name=other_agency]')['removeAttr'](_0xa6a347(0xed))):($(_0xa6a347(0xd7))[_0xa6a347(0xef)](),$(_0xa6a347(0xf1))[_0xa6a347(0xef)](),$(_0xa6a347(0xd7))['attr']('disabled',_0xa6a347(0x111))),$(_0xa6a347(0x102))[_0xa6a347(0xf3)]('show');}else{}}}),![];}),$(_0x26b271(0x105))['on']('click',_0x26b271(0xdf),function(_0x5ab606){var _0x4370ef=_0x26b271;if(!confirm(_0x4370ef(0x104)))return![];_0x5ab606[_0x4370ef(0xd4)]();var _0x202858=$(this)[_0x4370ef(0x10d)]('id'),_0x3c0f33=$(_0x4370ef(0xe8))['attr']('content');return $[_0x4370ef(0xdb)]({'url':'/kerjasamaAgensi/destroy/'+_0x202858,'type':'DELETE','data':{},'success':function(_0x141c09){var _0x25ff97=_0x4370ef;if(_0x141c09['status'])loadData(),Swal[_0x25ff97(0xee)]({'icon':_0x25ff97(0xe3),'title':'Success!','text':_0x141c09[_0x25ff97(0xd3)],'showConfirmButton':!![]});else{}}}),![];}),$(_0x26b271(0x105))['on'](_0x26b271(0xf9),_0x26b271(0xd5),function(_0x1c9fc3){var _0x153f10=_0x26b271;_0x1c9fc3[_0x153f10(0xd4)]();var _0x4040b9=$(this),_0x31c94a=$(_0x153f10(0x10a)),_0x1f8285=_0x4040b9['find'](_0x153f10(0x103))['val']();$[_0x153f10(0xdb)]({'url':_0x153f10(0xdd)+_0x1f8285,'type':_0x153f10(0xe1),'data':{'_token':_0x31c94a[_0x153f10(0xfb)](),'agency':_0x4040b9[_0x153f10(0xfe)](_0x153f10(0xd8))[_0x153f10(0xfb)](),'other_agency':_0x4040b9[_0x153f10(0xfe)]('input[name=other_agency]')[_0x153f10(0xfb)](),'collaboration_matters':_0x4040b9[_0x153f10(0xfe)](_0x153f10(0xf0))[_0x153f10(0xfb)](),'collaboration_date':_0x4040b9['find']('input[name=collaboration_date]')[_0x153f10(0xfb)]()}})[_0x153f10(0x10b)](function(_0x49bde2){var _0x1358aa=_0x153f10;_0x31c94a['val'](_0x49bde2[_0x1358aa(0xd6)]);if(_0x49bde2[_0x1358aa(0xfc)])$(_0x1358aa(0x102))['modal']('hide'),loadData(),Swal[_0x1358aa(0xee)]({'icon':_0x1358aa(0xe3),'title':'Success!','text':_0x49bde2['message'],'showConfirmButton':!![]});else{}_0x31c94a[_0x1358aa(0xfb)](_0x49bde2[_0x1358aa(0xd6)]);});});}),$(_0x628c31(0xd8))['on'](_0x628c31(0xcf),function(){var _0x2d0394=_0x628c31,_0x1e0d84=$(this)[_0x2d0394(0xfe)](':selected')['val']();console[_0x2d0394(0x106)](_0x2d0394(0x108)+_0x1e0d84),_0x1e0d84==0x0?($(_0x2d0394(0xd7))[_0x2d0394(0xf4)](),$('label[name=label_agency]')[_0x2d0394(0xf4)](),$(_0x2d0394(0xd7))[_0x2d0394(0xe0)](_0x2d0394(0xed))):($(_0x2d0394(0xd7))['hide'](),$('label[name=label_agency]')[_0x2d0394(0xef)](),$(_0x2d0394(0xd7))[_0x2d0394(0xe6)]('disabled',_0x2d0394(0x111)));});
    </script>
@endsection
