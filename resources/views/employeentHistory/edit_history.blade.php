@extends('home')
@section('title-dashboard', 'Manpower')
@section('title','Employment History')

@section('breadcrumb')
<? $user = Auth::user()->id; ?>
<li class="breadcrumb-item active"><a href="/employmentDetail/{{$user}}">Employment History</a></li>
<li class="breadcrumb-item active">Edit</li>

@endsection

@section('content')
@include('employee.redbar.function_employment_details')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Edit Employment History</h3>
    </div>
    <div class="card-body">
        <form action="{{URL::to('employmentDetail/employment_history/update/'.$data->id_employment_history.'')}}" method="POST" enctype="multipart/form-data">
            @csrf
            
    		@if ($message = Session::get('success'))
                <div class="alert alert-success">
                    <p>
                        {{ $message }}
                        <a class="close" aria-hidden="true" data-dismiss="alert">x</a>
                    </p>
                </div>
            @endif
            
            <div class="row">
                <div class="col-md-9">
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="#" class="col-sm-4 col-form-label">Company</label>
                            <div class="col-sm-8">
                                <input type="text" value="{{isset($data->company)?$data->company:""}}" class="form-control" name="company" required autofocus>
                            </div>
                            
                        </div>
                        <div class="form-group row">
                            <label for="#" class="col-sm-4 col-form-label">Position</label>
                            <div class="col-sm-8">
                                <select class="form-control select2 select_position" name="id_position" required autofocus>
							        <option selected disabled value="">Select your position</option>
							        @foreach(\App\Models\Position::get() as $pos)
							        <option value="{{$pos->id_position}}" {{(old('id_position')==$pos->id_position)? 'selected':''}}>
							            {{ $pos->position }}
							        </option>
							        @endforeach
							    </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="#" class="col-sm-4 col-form-label">Field of Work</label>
                            <div class="col-sm-8">
                                <select class="form-control select2 select_segment" name="id_segment" required autofocus>
							        <option selected disabled value="">Select Field of Work</option>
							        @foreach(\App\Models\Segment::where('id_segment','>','0')->get() as $seg)
							        <option value="{{$seg->id_segment}}" {{(old('id_segment')==$seg->id_segment)? 'selected':''}}>
							            {{ $seg->segment}}
							        </option>
							        @endforeach
							    </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="#" class="col-sm-4 col-form-label">From Date</label>
                            <div class="col-sm-8">
                                <input type="date" value="{{isset($data->from_date)?$data->from_date:""}}" class="form-control" name="from_date" required autofocus>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="#" class="col-sm-4 col-form-label">To Date</label>
                            <div class="col-sm-8">
                                <input type="date" value="{{isset($data->to_date)?$data->to_date:""}}" class="form-control" name="to_date" required autofocus>
                            </div>
                        </div>
                        
                         <div class="form-group row">
                            <label for="#" class="col-sm-4 col-form-label">Certificate</label>
                            <div class="col-sm-8">
                                 <a href="/EMPLOY/{{$data->certificate}}" target="new">
                                <input class="form-control"  value="{{$data->certificate}}" readonly>
								</a>
                            </div>
                        </div>
                         <div class="form-group row">
                            <label for="#" class="col-sm-4 col-form-label">Change Certificate</label>
                            <div class="col-sm-8">
                                <input  name="certificate" type="file" class="form-control ">
								
                            </div>
                        </div>
                    </div>
                </div>
                <div></div>
            </div>
            <div class="card-footer">
                <a href="/employmentDetail/{{$user}}" class="btn btn-sm btn-dark">Back</a>	
                <input type="submit" value="Update" class="pull-right btn btn-primary">
            </div>
        </form>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script> 
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>

<script>
    <?
        $position_id = $data->position->id_position;
        echo "var position_id = '$position_id';";
        $name_position = isset($data->position->position)?$data->position->position:"";
        echo "var name_position = '$name_position';";
        
        $segment_id = $data->segment->id_segment;
        echo "var segment_id = '$segment_id';";
        $name_segment = isset($data->segment->segment)?$data->segment->segment:"";
        echo "var name_segment = '$name_segment';";
    ?>
    
    searchPosition = $('.searchPosition');
    var $option = $('<option selected="selected"></option>').val(position_id).text(name_position);
    searchPosition.append($option).trigger('change');
    
    searchSegment = $('.searchSegment');
    var $option = $('<option selected="selected"></option>').val(segment_id).text(name_segment);
    searchSegment.append($option).trigger('change');
    
    // $(".searchPosition").select2({
    // placeholder: "Please Select",
    // ajax: {
    //     url: "/getPosition",
    //     dataType: "json",
    //     delay: 250,
    //     processResults: function (data) {
    //         return {
    //             results: $.map(data, function (item) {
    //                     item_text =  item.position;
    //                     return {
    //                         text: item_text,
    //                         id: item.id_position
    //                     };
    //             })
    //         };
    //     },
    //     cache: false
    // }
    // });
    
    //  $(".searchSegment").select2({
    // placeholder: "Please Select",
    // ajax: {
    //     url: "/getSegment",
    //     dataType: "json",
    //     delay: 250,
    //     processResults: function (data) {
    //         return {
    //             results: $.map(data, function (item) {
    //                     item_text =  item.segment;
    //                     return {
    //                         text: item_text,
    //                         id: item.id_segment
    //                     };
    //             })
    //         };
    //     },
    //     cache: false
    // }
    // });
</script>

@endsection