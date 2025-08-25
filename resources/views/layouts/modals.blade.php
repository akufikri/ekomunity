<link href="{{ asset('css/success_tic.css') }}" rel="stylesheet">

<div class="modal fade" tabindex="-1" id="isFailed" role="dialog" aria-labelledby="failed">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body text-center">
                <div class="modal-body">
                    <img src="{{asset('images/icon_failed.png')}}" width="35%" height="40%">
                    <br>
                    <p class="mt-4">
                        <span style="font-weight:bold" id="f_message">
                        </span>
                    </p>
                    <hr>
                    <a href="#" class="btn btn-transparent btn-md text-dark" style="font-weight:bold; font-size:15px" data-dismiss="modal">Close</a>
                </div>
                <!--<div class="modal-footer">-->
                    
                <!--</div>-->
            </div>
        </div>
    </div>
</div>

<div class="modal fade" tabindex="-1" id="isInfo" role="dialog" aria-labelledby="info">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body text-center">
                <div class="modal-body">
                    <img src="{{asset('images/icon_failed_blue.png')}}" width="35%" height="40%">
                    <br>
                    <p class="mt-4">
                        <span style="font-weight:bold" id="i_message">
                        </span>
                    </p>
                    <hr>
                    <a href="#" class="btn btn-transparent btn-md text-dark" style="font-weight:bold; font-size:15px" data-dismiss="modal">Close</a>
                </div>
                <!--<div class="modal-footer">-->
                    
                <!--</div>-->
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_create_md" role="dialog" aria-labelledby="create">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" id="create_content">
            <div class="modal-header">
                <h5 class="modal-title">New</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            
            <div class="modal-body" id="create_body">
                    
            </div>
            <div class="modal-footer" id="create_footer">
                <!--<a href="#" class="btn btn-info btn-md text-light" style="font-weight:bold; font-size:15px" data-dismiss="modal">Close</a>-->
            </div>
        </div>
    </div>
</div>

<div class="modal fade" tabindex="-1" id="isWarning" role="dialog" aria-labelledby="warning">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body text-center">
                <div class="modal-body">
                    <img src="{{asset('images/icon_failed.png')}}" width="30%" height="30%">
                    <br>
                    <p class="mt-4">
                        <span style="font-weight:bold" id="w_message">
                        </span>
                    </p>
                </div>
                <div class="modal-footer" id="w_btn">
                    
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" tabindex="-1" id="isWarningLgPolos" role="dialog" aria-labelledby="warning">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-body text-center">
                <div class="modal-body">
                    <div class="w_lgp_icon">
                    </div>
                    <br>
                    <p class="mt-4">
                        <span style="font-weight:bold" id="w_lgp_message">
                        </span>
                    </p>
                </div>
                <div class="modal-footer" id="w_lgp_btn">
                    
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="success_tic" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body text-center">
                <div class="modal-body">
                    <h3 style="text-align:center;">
                        <div class="checkmark-circle">
                            <div class="background"></div>
                            <div class="checkmark draw"></div>
                        </div>
                    </h3>
                    <br>
                    <p class="mt-4">
                        <span style="font-weight:bold" id="s_message">
                        </span>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<style type="text/css">
	.wait-content{
	    -webkit-box-shadow: 0 5px 15px rgba(0,0,0,0);
	    -moz-box-shadow: 0 5px 15px rgba(0,0,0,0);
	    -o-box-shadow: 0 5px 15px rgba(0,0,0,0);
	    box-shadow: 0 5px 15px rgba(0,0,0,0);
	}
    .modal_loading{
        z-index: 1999;
    }
</style>
<div class="modal fade bg-transparent modal_loading" id="modalWait" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static" data-keyboard="false" style="border: none">
    <div class="modal-dialog modal-dialog-centered bg-transparent" style="border: none">
        <div class="modal-content wait-content bg-transparent" style="border: none">
            <div class="modal-body text-center" style="border: none">
                <img src="{{asset('landingpage/images/loading.svg')}}" class="load_img" width="50px" height="50px">
            </div>
        </div>
    </div>
</div>