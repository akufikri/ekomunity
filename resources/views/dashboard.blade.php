@extends('home')
@section('title-dashboard', 'Admin')
@section('title','Admin')

@section('breadcrumb')

<li class="breadcrumb-item active"><a>Dashboard</a></li>
@endsection

@section('content')

<style>
  .title {
      font-size: 1.25rem; 
      font-weight: bold;
  }
  .select2-container--default .select2-selection--single {
  border: 1px solid #ced4da;
  height: calc(2.875rem + 2px) !important;
  padding: 1.2rem 1rem 2.5rem 1rem;
  font-size: 1.25rem;
  line-height: 1.5;
  border-radius: .3rem;
  }
  .form-control-lg2 {
  border: 1px solid #ced4da;
  height: calc(2.875rem + 2px) !important;
  padding: 1.2rem 1rem 2.5rem 1rem;
  font-size: 1.25rem;
  line-height: 1.5;
  border-radius: .3rem;
  }
  .form-control-lg{
      height: calc(2.875rem + 2px);
      padding: 2rem 1.2rem;
      font-size: 1.25rem;
      line-height: 1.5;
      border-radius: .3rem;
  }
  .form-control-lgku{
      height: calc(2.875rem + 2px);
      padding: 2rem 1.2rem;
      font-size: 1.25rem;
      line-height: 1.5;
      border-radius: .3rem;
  }
  .filldata {
  font-weight: normal !important;
  }
  #label_form {
      padding-bottom: 8px; font-size: 15px;
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
      text-align: center;
      margin-bottom: 0px;
  }
  .my-table {
      font-size: 14px;
      margin-bottom: 0px;
  }
  
  input[type="text"]
  {
      font-size:14px;
  }
  
  input[type="number"]
  {
      font-size:14px;
  }
  
  input[type="file"]
  {
      font-size:14px;
  }
  
  input[type="button"]
  {
      font-size:14px;
  }
</style>

    <div class="row">
         
          <!-- /.col (LEFT) -->
          <div class="col-md-2">
              <div class="form-group">
                <label for="exampleInputEmail1">Filter</label>
                <select class="form-control form-control-sm filter" name="filter" id="filter" required autofocus>
                  <option selected value="Daily">Harian</option>
                  <option value="Monthly">Bulanan</option>
                  <option value="Yearly">Tahunan</option>
                </select> 
              </div>
          </div>
          <div class="col-md-12">
              
            <!-- BAR CHART -->
            <div class="card card-info">
              <div class="card-header">
                <h3 class="card-title">Graf Registrasi Ahli</h3>

                <!--<div class="card-tools">-->
                <!--  <button type="button" class="btn btn-tool" data-card-widget="collapse">-->
                <!--    <i class="fas fa-minus"></i>-->
                <!--  </button>-->
                <!--  <button type="button" class="btn btn-tool" data-card-widget="remove">-->
                <!--    <i class="fas fa-times"></i>-->
                <!--  </button>-->
                <!--</div>-->
              </div>
              <div class="card-body">
                <div class="chart">
                  <canvas id="barChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                </div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

           

          </div>
          <!-- /.col (RIGHT) -->
    </div>


<script>
  $(function () {
      
      loadStats('Daily');
    
    
    $('select.filter').change(function(){
        
        loadStats($('select.filter').val());
        
        // alert($('select.filter').val());
        
        // if($('select.filter').val() === '0')
        // form.find('input[name=others_segment]').val($('select.segment').val());
        // form.find('input[name=others_segment_add]').attr('disabled', false);
        // else
        // form.find('input[name=others_segment]').val('');
        // form.find('input[name=others_segment_add]').val('').attr('disabled', true);

    });
    

    // areaChartData = {
    //   labels  : ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
    //   datasets: [
    //     {
    //       label               : 'Digital Goods',
    //       backgroundColor     : 'rgba(60,141,188,0.9)',
    //       borderColor         : 'rgba(60,141,188,0.8)',
    //       pointRadius          : false,
    //       pointColor          : '#3b8bba',
    //       pointStrokeColor    : 'rgba(60,141,188,1)',
    //       pointHighlightFill  : '#fff',
    //       pointHighlightStroke: 'rgba(60,141,188,1)',
    //       data                : [2, 0, 0, 0, 0, 0, 0]
    //     },
    //     {
    //       label               : 'Electronics',
    //       backgroundColor     : 'rgba(210, 214, 222, 1)',
    //       borderColor         : 'rgba(210, 214, 222, 1)',
    //       pointRadius         : false,
    //       pointColor          : 'rgba(210, 214, 222, 1)',
    //       pointStrokeColor    : '#c1c7d1',
    //       pointHighlightFill  : '#fff',
    //       pointHighlightStroke: 'rgba(220,220,220,1)',
    //       data                : [65, 59, 80, 81, 56, 55, 40]
    //     },
    //   ]
    // }

    
   
  })
  
  function loadStats(filter){
      
    $.ajax(
    {
        url: "/getStatsRegisterAhli?filter="+filter,
        type: 'GET',
        data: {
            // _token: token,
                // id: id
        },
        success: function (response){
            
            var areaChartData = response;
            
            var areaChartOptions = {
              maintainAspectRatio : false,
              responsive : true,
              legend: {
                display: false
              },
              scales: {
                xAxes: [{
                  gridLines : {
                    display : false,
                  }
                }],
                yAxes: [{
                  gridLines : {
                    display : false,
                  }
                }]
              }
            }
            
            
            var barChartCanvas = $('#barChart').get(0).getContext('2d')
        
            // This will get the first returned node in the jQuery collection.
            var areaChart = new Chart(barChartCanvas, {
              type: 'line',
              data: areaChartData,
              options: areaChartOptions
            })
        
         
            //-------------
            //- BAR CHART -
            //-------------
            var barChartCanvas = $('#barChart').get(0).getContext('2d')
            var barChartData = $.extend(true, {}, areaChartData)
            
        
            var temp0 = areaChartData.datasets[0]
            var temp1 = areaChartData.datasets[1]
            barChartData.datasets[0] = temp1
            barChartData.datasets[1] = temp0
        
            var barChartOptions = {
              responsive              : true,
              maintainAspectRatio     : false,
              datasetFill             : false
            }
        
            var barChart = new Chart(barChartCanvas, {
              type: 'bar',
              data: barChartData,
              options: barChartOptions
            })
            
        }
    });  
      
  }
</script>
    
@endsection
