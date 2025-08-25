@extends('home')
@section('title-dashboard', 'Company')
@section('content')

@include('company.redbar.function_pay-up_capital')
<div class="row" id="viewEdit">
          <div class="col-12">
            <!-- Default box -->
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Edit Equity Breakdown</h3>
              </div>
              <div class="card-body">
                  <form action="{{URL::to('companyEquityBreakdown/update/'.$data->id.'')}}#view" method="POST" enctype="multipart/form-data">
                      @csrf
            
                		@if ($message = Session::get('success_update'))
                            <div class="alert alert-success">
                                <p>
                                    {{ $message }}
                                    <a class="close" aria-hidden="true" data-dismiss="alert">x</a>
                                </p>
                            </div>
                        @endif
                      <div class="row">
                       <div class="col-md-12">
                        <div class="card-body">
                            
                            <div class="form-group row">
                                <label for="#" class="col-sm- col-form-label">Authorize Paid Up Capital</label>
                                <div class="input-group">
                                  <div class="input-group-prepend">
                                    <span class="input-group-text">RM</span>
                                  </div>
                                  <input type="text" name ="auth_paid_up_capital" id="auth_paid_up_capital" value="{{isset($data->company->auth_paid_up_capital)?$data->company->auth_paid_up_capital:""}}" class="form-control">
                                  
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="#" class="col-sm-2 col-form-label">Paid Capital</label>
                                <div class="input-group">
                                  <div class="input-group-prepend">
                                    <span class="input-group-text">RM</span>
                                  </div>
                                  <input type="text" class="form-control"  value="{{isset($data->company->paid_up_capital)?$data->company->paid_up_capital:""}}" name ="paid_up_capital" id="paid_up_capital" disabled>
                                  
                                </div>
                            </div>
                        </div>
                      </div>
                  </div>
                      <!-- /.card-body -->
                      <div class="card-footer">
                        <a href="{{URL::to('companyEquityBreakdown/'.Auth::user()->id)}}#view" class="btn btn-sm btn-primary">Back</a>
                        <input type="submit" value="Update" class="pull-right btn-sm btn-success"> 
                      </div>
                      <!-- /.card-footer-->
                  </form>
                    
               </div>
            <!-- /.card -->
          </div>
        </div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script>
    $('#price').on('change click keyup input paste',(function (event) {
    $(this).val(function (index, value) {
        s= '' + value.replace(/(?!\.)\D/g, "").replace(/(?<=\..*)\./g, "").replace(/(?<=\.\d\d).*/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
       s = s.replace(/,/g, '');
      return  s;
    });
}));
$('#price1').on('change click keyup input paste',(function (event) {
    $(this).val(function (index, value) {
        s= '' + value.replace(/(?!\.)\D/g, "").replace(/(?<=\..*)\./g, "").replace(/(?<=\.\d\d).*/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
       s = s.replace(/,/g, '');
      return  s;
    });
}));
</script>

@endsection