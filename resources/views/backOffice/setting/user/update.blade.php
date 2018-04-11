@extends('layouts.backOffice.template')

@section('head')
    <link rel="stylesheet" type="text/css" href="{{ asset('/css/back-office/setting/user/create.css')}}"/>
@endsection

@section('module_name', 'MODULE_NAME')
@section('page_name', 'PAGE_NAME')

@section('body')
<div class="x_content scroll-2">
  <form id="form-create-user" action="{{ route('backOffice.setting.user.update', ['id'=>$user->id]) }}" method="POST" enctype="multipart/form-data">
      {!! csrf_field() !!}{!! method_field('PATCH') !!}
      <div id="profileBox">
          <div class="media" id="accountInfo">
          <div class="media-left">
              <div class="upload-btn-wrapper">
                  <img
                    @if($user->image1 != NULL) src="{{ asset($user->image1) }}"
                    @else src="{{ asset('images/avatar.png') }}" @endif
                    class="profilePicture">
                  <input type="file" name="image1" id="profilePictureField1" />
                  <p class="file-name"><input type="radio" value="image1" class="iCheck"> N-JOY</p>
              </div>
              <div class="upload-btn-wrapper">
                  <img
                    @if($user->image1 != NULL) src="{{ asset($user->image2) }}"
                    @else src="{{ asset('images/avatar.png') }}" @endif
                    class="profilePicture">
                  <input type="file" name="image2" id="profilePictureField2" />
                  <p class="file-name"><input type="radio" value="image2" class="iCheck">ZENG-N</p>
              </div>
              <div class="form-group">
                  <label for="status">Status:</label>
                  <textarea name="description_status" class="form-control" rows="3">{{ old('description_status', optional($user)->description_status) }}</textarea>
              </div>
              <input type="hidden" id="imageShow" name="imageShow" value="{{ old('image_show', optional($user)->image_show) }}">
          </div>
          <div class="media-body">
              <div class="row">
                  <div class="col-xs-6">
                      <div class="form-group">
                          <label>MEMBER NUMBER</label>
                          <input type="text" class="form-control" name="member_number" id="member_number" placeholder="member number" value="{{ old('member_number', optional($user)->member_number) }}" required>
                      </div>
                  </div>
                  <div class="col-xs-6">
                      <div class="form-group">
                          <label>REGISTER DAY</label>
                          <div class="input-group date" id="datepicker" >
                              <input type="text" class="form-control" name="register_date" id="register_date" value="{{old('register_date', optional($user)->registerDate->fullDate)}}"/>
                              <span class="input-group-addon">
                                  <i class="fa fa-calendar" ></i>
                              </span>
                          </div>
                      </div>
                  </div>
              </div>
              <div class="row">
                  <div class="col-xs-6">
                      <div class="form-group">
                          <label for="">Firstname:</label>
                          <input type="text" class="form-control" name="first_name" id="first_name" placeholder="firstname" value="{{ old('first_name', optional($user)->first_name) }}" required>
                      </div>
                  </div>
                  <div class="col-xs-6">
                      <div class="form-group">
                          <label for="">Lastname:</label>
                          <input type="text" class="form-control" name="last_name" id="last_name" placeholder="lastname" value="{{ old('last_name', optional($user)->last_name) }}" required>
                      </div>
                  </div>
              </div>
              <div class="row">
                  <div class="col-xs-3">
                      <div class="form-group">
                          <label for="">Nickname:</label>
                          <input type="text" class="form-control" name="nick_name" id="nick_name" placeholder="nickname" value="{{ old('nick_name', optional($user)->nick_name) }}" required>
                      </div>
                  </div>
                  <div class="col-xs-3">
                      <div class="form-group">
                          <label for="">Gender:</label>
                          <select id="basic" name="gender" class="form-control">
                              <option value="">-- select --</option>
                              <option value="male" @if(old('gender', optional($user)->gender) == 'male') selected @endif>Male</option>
                              <option value="female" @if(old('gender', optional($user)->gender) == 'female') selected @endif>Female</option>
                              </select>
                      </div>
                  </div>
                  <div class="col-xs-6">
                      <label for="">Birthdate:</label>
                      <div class="input-group date" id="datepicker" >
                          <input type="text" class="form-control" name="birthdate" id="birthdate" value="{{old('birthdate', optional($user)->birthDate->fullDate)}}"/>
                          <span class="input-group-addon">
                              <i class="fa fa-calendar" ></i>
                          </span>
                      </div>
                  </div>
              </div>
              <div class="row">
                  <div class="col-xs-6">
                      <div class="form-group">
                          <label for="">E-Mail:</label>
                          <input type="email" class="form-control" name="email" id="email" placeholder="email" value="{{ old('email', optional($user)->email) }}" required>
                      </div>
                  </div>
                  <div class="col-xs-6">
                      <div class="form-group">
                          <label for="">Phone:</label>
                          <input type="text" class="form-control" name="phone" id="phone" placeholder="phone" value="{{ old('phone', optional($user)->phone) }}" required>
                      </div>
                  </div>
              </div>
              <div class="row">
                  <div class="col-xs-6">
                      <div class="form-group">
                          <label for="">Password:</label>
                          <input type="password" class="form-control" name="password" id="password" placeholder="password" value="" required>
                      </div>
                  </div>
                  <div class="col-xs-6">
                      <div class="form-group">
                          <label for="">Confirm Password:</label>
                          <input type="password" class="form-control" name="confirm_password" id="confirm_password" placeholder="confirm password" value="" required>
                      </div>
                  </div>
              </div>
          </div>
        </div>
          <div id="permission">
              <div id="staffPermission" class="table-responsive">
                  <table class="table table-nonbordered user-status">
                      <thead>
                          <tr>
                              <th>Right:</th>
                          </tr>
                      </thead>
                      <tbody>
                          <tr>
                              <td>
                                  <label>
                                      <input type="radio" name="userRight" value="admin" class="iCheck" @if(old('user_right', optional($user)->user_right)=='admin') checked @endif>
                                      <span>Administrator (ADMIN)</span>
                                  </label>
                              </td>
                          </tr>
                          <tr>
                              <td>
                                  <label>
                                      <input type="radio" name="userRight" value="staff" class="iCheck" @if(old('user_right', optional($user)->user_right)=='staff') checked @endif>
                                      <span>Staff </span>
                                  </label>
                              </td>
                          </tr>
                      </tbody>
                  </table>
                  <table class="table table-nonbordered table-permission">
                      <thead>
                          <tr>
                              <th style="width: 22%;">Department</th>
                              @foreach($data['roles'] as $role)
                              <th style="width: 22%;">{{ strtoupper($role->name) }}</th>
                              @endforeach
                          </tr>
                      </thead>
                      <tbody>
                          @foreach($data['departments'] as $department)
                          <tr>
                              <td>{{ ucfirst($department->name) }}</td>
                              @foreach($data['roles'] as $role)
                              <td>
                                  <label>
                                      <input type="radio" name="userPrivilege[{!! $department->id !!}]" class="iCheck" value="{!! $role->id !!}" @if(array_first($data['permissions']->where('department_id', $department->id))->role_id==$role->id) checked @endif>
                                      <span></span>
                                  </label>
                              </td>
                              @endforeach
                          </tr>
                          @endforeach
                      </tbody>
                  </table>
              </div>
          <div class="actions" align="center">
              <button type="submit" class="btn btn-ngin btn-default"><span class="btn-label"><i class="fa fa-floppy-o success" aria-hidden="true"></i> </span>SAVE</button>
              <button type="button" class="btn btn-ngin btn-default"><span class="btn-label"><i class="fa fa-times-circle-o danger" aria-hidden="true"></i> </span>CANCEL</button>
          </div>
        </div>
      </div>
  </form>
</div>
@endsection

@section('script')
<script src="{{ asset('js/back-office/setting/user/create.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function(){
        //Set Label Header Page
        $('#lbHeaderPage').html("<h3>USER | <span>UPDATE</span></h3>");
    });
</script>
<script>
    $(function() {
        toastr.options = {
            "closeButton": true,
            "debug": false,
            "newestOnTop": true,
            "positionClass": "toast-top-center",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "3000",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        }
    @if(session()->has('success'))
        toastr["success"]("{{ Session::get('success') }}", "Success");
    @elseif(session()->has('warning'))
        toastr["warning"]("{{ Session::get('warning') }}", "Warning");
    @endif
    @if ($errors->any())
        @foreach ($errors->all() as $error)
        toastr["error"]("{{ $error }}", "Warning");
        @endforeach
    @endif

    });
</script>

@endsection
