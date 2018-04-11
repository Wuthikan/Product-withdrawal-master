@extends('layouts.auth.template')

@section('head')
    <!-- base core css -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300" rel="stylesheet">
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
        <p id="resetLabel">Forget Password</p>
        <form id="marginTop" action="{{route('password.email')}}" method="POST">
          {{csrf_field()}}
          <div class='form-group'>
            <div id='inputLabel'>Email</div>
            <input type="email" name="email" class="form-control" />
          </div>
          <div class="loginContainer">
            <button type="submit" class="btn btn-ngin btn-default ngin-no-icon">
              Send Email
            </button>
          </div>
          @if($errors->any())
          <div class="alert alert-danger">
            @foreach($errors->all() as $error)
            <i class="fa fa-exclamation-triangle" aria-hidden="true"></i> {{$error}}
            @endforeach
          </div>
          @endif
          @if(!empty(session()->has('reset_status')))
          <div class="alert alert-success">{{__(session()->get('reset_status'))}}</div>
          @endif
        </form>
      </div>
    </div>
@endsection

@section('footer')
  <footer></footer>
@endsection

@section('script')
@endsection
