@extends('layouts.auth.template')

@section('head')
    <link rel="stylesheet" type="text/css" href="{{ asset('/css/auth/login.css')}}"/>
@endsection

@section('header')
    <header></header>
@endsection

@section('body')
  <nav class="navbar"></nav>
  <div class="container-fluid">
    <div id="container">
        <img id="logo" src="{{ asset('/images/logo.png') }}">
        <p id="resetLabel">Reset Password</p>
        <form id="marginTop" action="{{ route('password.request') }}" method="POST">
          {{csrf_field()}}
          <input type="hidden" name="token" value="{{ $token }}" />
          <input type="hidden" name="email" value="{{ $email }}" />
          <div class='form-group'>
            <div id='inputLabel'>Password</div>
            <input type="password" name="password" class="form-control" />
          </div>
          <div class='form-group'>
            <div id='inputLabel'>Confirm Password</div>
            <input type="password" name="password_confirmation" class="form-control" />
          </div>
          <div class="loginContainer">
            <button type="submit" class="btn btn-ngin btn-default ngin-no-icon">
              Save
            </button>
          </div>
          @if ($errors->any())
          <div class="alert alert-danger">
            @foreach($errors->all() as $error)
            <i class="fa fa-exclamation-triangle" aria-hidden="true"></i> {{$error}}
            @endforeach
          </div>
          @endif
          {{--
          <div class="alert alert-success">
            Success!
          </div>
          --}}
        </form>
      </div>
    </div>
@endsection

@section('footer')
  <footer></footer>
@endsection

@section('script')
@endsection
