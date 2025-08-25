@extends('home')
@section('title-dashboard', 'Admin')
@section('title','Admin')

@section('breadcrumb')

<li class="breadcrumb-item active">Settings Term Conditions</li>

@endsection

@section('content')

<div class="row">
    <div class="col-12">
        <div class="card card-primary card-outline" style="border-top: 3px solid dark">
            <div class="card-header">
                <h3 class="card-title">Settings Term Coditions</h3>
                <!--<div class="card-tools">-->
                <!--    <a href="#" data-toggle="modal" data-target="#addQualification"  class="btn btn-sm btn-success pull-right">-->
                <!--        <i class="fa fa-plus nav-icon"></i>-->
                <!--        &nbsp; Add-->
                <!--    </a>-->
                <!--</div>-->
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="container mt-2">
                        <form>
                            @foreach(\App\Models\Term::get() as $dataku)
                                  <div class="row">
                                    <div class="col-sm-12">
                                      <!-- textarea -->
                                      <div class="form-group">
                                        <label>Term Condition 
                                        @if ($dataku->id_level ==='2')
                                        Company
                                        @else
                                        Manpower
                                        @endif</label>
                                        <textarea class="form-control" rows="10">{{$dataku->term_conditions}}</textarea>
                                      </div>
                                    </div>
                                  </div>
                            @endforeach
                            </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script> 
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>

<script src="//code.jquery.com/jquery-2.0.0.js"></script>
<script src="/js/jquery.validate.min.js"></script>
<script type="text/javascript">

</script>

@endsection