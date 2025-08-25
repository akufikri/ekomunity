<style>
    .main-header {}
</style>
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#"><i class="fa fa-bars"></i></a>
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        @guest
            <li class="nav-item">
                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
            </li>
        @else
            <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="dropdown" href="#">
                    {{ Auth::user()->fullname }} <i class="fa fa-angle-down"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" style="min-width: 250px;">
                    <div class="dropdown-item">
                        <div class="media">

                            <div class="media-body text-dark">
                                <h3 class="dropdown-item-title">
                                    {{ Auth::user()->fullname }}
                                </h3>
                                <?php $level = Auth::user()->id_level; ?>
                                @if ($level == 1)
                                    <p class="text-sm">ADMIN</p>
                                @elseif($level == 2)
                                    <p class="text-sm">CAWANGAN</p>
                                @elseif($level == 3)
                                    <p class="text-sm">AHLI</p>
                                @elseif($level == 4)
                                    <p class="text-sm">KETUA BAHAGIAN</p>
                                @elseif($level == 6)
                                    <p class="text-sm">ADMIN PUSAT</p>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item dropdown-footer text-dark text-right changePassword" data-toggle="modal"
                        data-id="{{ Auth::user()->id }}" data-target="#changePasswordModal" id="btn_change_password"
                        href="#" style="color: black !important;">
                        <i class="nav-icon fa fa-key"></i> Change Password
                    </a>
                    <a class="dropdown-item dropdown-footer text-dark text-right" id="btn_logout"
                        href="{{ route('logout') }}" style="color: black !important;"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="nav-icon fa fa-sign-out-alt"></i> Logout
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="dropdown" href="#">
                    <i class="far fa-bell"></i>
                    @if ($count > 0)
                        <span class="badge badge-danger navbar-badge"
                            style="font-size: .6rem; font-weight: 300; padding: 2px 4px; position: absolute; right: .1px; top: 5px;">{{ $count }}</span>
                    @endif
                </a>
                <div class="dropdown-menu dropdown-menu-xl dropdown-menu-right" style="width: 500px;">
                    <span class="dropdown-item dropdown-header" style="text-align: center;">{{ $count }} New
                        Notification</span>

                    @empty($inbox)
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-envelope mr-2"></i> Inbox Empty
                            <span class="float-right text-muted text-sm"></span>
                        </a>
                    @else
                        @foreach ($inbox as $i)
                            <div class="dropdown-divider"></div>
                            <a href="/read_inbox/{{ $i->id }}" class="dropdown-item">
                                <i class="fas fa-envelope mr-2"></i> {{ $i->inbox->title }}
                                <span class="float-left text-muted text-sm"
                                    style="text-wrap: wrap;">{{ $i->inbox->message }}</span>
                                <span
                                    class="float-right text-muted text-sm"><br>{{ $i->inbox->created_at->diffForHumans() }}</span>
                            </a>
                        @endforeach
                    @endempty

                </div>
            </li>
        @endguest
    </ul>
</nav>

<!--UPDATE Password-->
<div class="modal fade" id="changePasswordModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="" method="POST" class="form-change-password" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Change Password</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body my-table">
                    <div class="form-group">
                        <input type="hidden" name="id_user">
                        <label for="#">Password</label>
                        <input type="password" class="form-control" id="password" name="password"
                            placeholder="Password">
                    </div>
                    <div class="form-group">
                        <label for="#">Confirm Password</label>
                        <input type="password" class="form-control" id="confirm_password" name="confirm_password"
                            placeholder="Confirm Password">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Cancel</button>
                    <input type="submit" id="btnchangepassword" value="Save" class="btn btn-sm btn-success">
                </div>
            </div>
        </form>
    </div>
</div>
<!--END UPDATE Password-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script type="text/javascript">
    $(function() {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $("#btnchangepassword").click(function() {

            var password = $("#password").val();
            var confirmPassword = $("#confirm_password").val();
            if (password !== confirmPassword) {
                alert("Passwords not match.");
                return false;
            }
            return true;
        });

        $(document).on("click", ".changePassword", function(e) {
            // if(!confirm("Do you really want to do this?")) {
            //     return false;
            // }
            e.preventDefault();
            var id = $(this).data("id");
            var token = $("meta[name='csrf-token']").attr("content");
            var url = e.target;
            $.ajax({
                url: "/users/" + id + "/edit",
                type: 'GET',
                data: {
                    _token: token,
                    id: id
                },
                success: function(response) {
                    $("#success").html(response.message)

                    if (response.data != null) {
                        data = response.data
                        var form = $('.form-change-password');
                        form.find('input[name=id_user]').val(data.id);
                        // form.find('select[name=status]').val(data.is_active);

                        $('#changePasswordModal').modal('show');
                    } else {
                        // failedAlert('Not Found');
                    }
                }
            });
            return false;
        });

        $(document).on('submit', '.form-change-password', function(e) {
            e.preventDefault();
            var ini = $(this),
                input_token = $('input[name=_token]'),
                id = ini.find('input[name=id_user]').val(),
                url = '/users/update_password/' + id;
            var post_data = {
                is_ajax: true,
                _token: input_token.val(),
                password: ini.find('input[name=password]').val(),
                confirm_password: ini.find('input[name=confirm_password]').val(),
                // status: ini.find('select[name=status]').val(),

            };

            // var e_modal_wait = $("#modalWait");
            // showLoading(e_modal_wait);

            $.ajax({
                    url: url,
                    type: "POST",
                    data: post_data
                })
                .done(function(result) {
                    // var message = result.message;
                    // hideLoading(e_modal_wait);
                    if (result.isSuccess) {
                        $('#changePasswordModal').modal('hide');
                        // initData(param)
                        // successAlert(message);

                        loadData()
                        swal(
                            'Success!',
                            'Update Password Successfuly!',
                            'success'
                        )

                    } else {

                        alert(result.message)

                        // failedAlert(message);
                    }
                    input_token.val(result.newToken);
                })
                .fail(ajax_fail);

        });

    });
</script>
