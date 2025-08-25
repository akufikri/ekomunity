@extends('login.template')
@section('title-dashboard', 'Manpower')
@section('title', 'Servay')
@section('content')
<style>
    .btnku {
      background-color: white !important;
      color: #b91c1c !important;
      border: 2px solid #b91c1c !important;
    }

    .btnku:hover {
      background-color: #b91c1c !important;
      color: white !important;
    }
    /*==========*/
    .form-control-lg{
        height: calc(2.875rem + 2px) !important;
        padding: 1rem .8rem !important;
        font-size: 13px !important;
        line-height: 1.5 !important;
        border-radius: .3rem !important;
    }
    .labelku{
        font-size: 15px;
    }
    .titleku{
        font-size: 18px;
    }
    /*div.btn-group.bootstrap-select.form-control.form-control4.form-control-lg{*/
    /*    background: white !important;*/
    /*}*/
    .form-control4 {
        background: #fff none repeat scroll 0 0 !important;
        border: 0 none;
        box-shadow: 0px 0px 0px 0 rgb(0 0 0 / 0%) !important;
        font-size: 16px;
        height: 50px;
        padding: 0px 0px 0px 0px;
        margin: 0px 0px 0px 0px;
    }
    
    .bootstrap-select .dropdown-toggle {
    background-color: #f9faff !important;
    }
    .btn-group>.btn:first-child {
    margin-left: -10px;
    }
    .button-md {
    padding: 10px 18px;
    font-size: 16px;
    font-weight: 500;
    }
</style>

<div class="section-full content-inner shop-account">
    <div class="container">
        <div class="row">
			<div class="col-md-12 text-center">
				@if ($message = Session::get('success'))
                    <div class="alert alert-danger">
                        <p>
                            {{ $message }}
                            <a class="close" aria-hidden="true" data-dismiss="alert">x</a>
                        </p>
                    </div>
                @endif
			</div>
		</div>
        <div class="row">
			<div class="col-md-12 m-b30">
				<div class="p-a30 border-1  max-w500 m-auto">
					<div class="tab-content">
						<form action="/register_ahli/step_seven_update" method="POST" enctype="multipart/form-data">
                            @csrf
							<h4 class="font-weight-700 titleku">Kaji-selidik anggaran Pendapatan</h4>

                            <div class="form-group">
                                <label class="font-weight-700 labelku">Anggaran Pendapatan Harian <span style="color: #b91c1c;" >*</span> </label>
                                <input id="business_income_daily" type="number" class="form-control-lg form-control" name="business_income_daily" placeholder="Pendapatan Harian" autocomplete="Pendapatan Harian" required>

                                {{-- <select class="form-control form-control4 form-control-lg" name="id_business_income_daily" id="id_business_income_daily">
                                    <option selected disabled value="">Pilih Anggaran Pendapatan Harian</option>
                                    @foreach($business_income_daily as $d)
                                    <option value="{{ $d->id_business_income }}">{{ $d->business_income }}</option>
                                    @endforeach
                                </select> --}}
                            </div>

                            <div class="form-group">
                                <label class="font-weight-700 labelku">Anggaran Pendapatan Mingguan <span style="color: #b91c1c;" >*</span> </label>
                                <input id="business_income_weekly" type="number" class="form-control-lg form-control" name="business_income_weekly" placeholder="Pendapatan Mingguan" autocomplete="Pendapatan Mingguan" required>
                                
                                {{-- <select class="form-control form-control4 form-control-lg" name="id_business_income_weekly" id="id_business_income_weekly">
                                    <option selected disabled value="">Pilih Anggaran Pendapatan Mingguan</option>
                                    @foreach($business_income_weekly as $d)
                                    <option value="{{ $d->id_business_income }}">{{ $d->business_income }}</option>
                                    @endforeach
                                </select> --}}
                            </div>

                            <div class="form-group">
                                <label class="font-weight-700 labelku">Anggaran Pendapatan Bulanan <span style="color: #b91c1c;" >*</span> </label>
                                <input id="business_income_monthly" type="number" class="form-control-lg form-control" name="business_income_monthly" placeholder="Pendapatan Bulanan" autocomplete="Pendapatan Bulanan" required>

                                {{-- <select class="form-control form-control4 form-control-lg" name="id_business_income_monthly" id="id_business_income_monthly">
                                    <option selected disabled value="">Pilih Anggaran Pendapatan Bulanan</option>
                                    @foreach($business_income_monthly as $d)
                                    <option value="{{ $d->id_business_income }}">{{ $d->business_income }}</option>
                                    @endforeach
                                </select> --}}
                            </div>

							<div id="submitButton" class="text-left">
								<button class="site-button button-md outline outline-2 btnku btn btn-md" type="submit">Next</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background: white">
                <p class="modal-title" style="color: black;" id="exampleModalLabel">Terms & Conditions</p>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?php
                $term = App\Models\Term::where('id_level',3)->get();
            ?>
            <div class="modal-body" style="overflow: auto; height: 400px; padding: 10px;">
                @foreach($term as $terms)
                    <p style="font-size:10px; text-align:justify;">{{$terms->term_conditions}}</p>
                @endforeach
            </div>
            <div class="modal-footer" style="height: 50px;">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<script type="text/javascript" src="/js/my-custom.js"></script>
<script type="text/javascript">
    $(function () {

        $('#submitButton').on('click', function() {
            var daily = $('#business_income_daily').val()
            var weekly = $('#business_income_weekly').val()
            var monthly = $('#business_income_monthly').val()

            console.log(weekly);
            

            if(daily == null){
                alert("Wajib pilih pendapatan harian")
                return false
            } else if(weekly == null){
                alert("Wajib pilih pendapatan mingguan")
                return false
            } else if(monthly == null){
                alert("Wajib pilih pendapatan bulanan")
                return false
            }
        })

    });
    
</script>
@endsection    