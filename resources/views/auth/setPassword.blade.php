 
@extends('layouts.app')

@section('content')

  <body class="login">
    <div>
        <section class="login_content col-md-3">
          <form method="POST" action="{{ url('user/update_password')}}" aria-label="{{ __('Login') }}" id="setPassword">
              @csrf
              @method('patch')      
            <h1>Set Password</h1>
            <div class="form-group text-left">
              <input type="email" class="form-control" id="email" placeholder="Email"    name="email"  readonly="readonly" value="{{ $user->email }}" />
              <input type="hidden" name="id" value="{{ $user->id }}" readonly="readonly">
            </div>
            <div class="form-group text-left">
              <input type="password" class="form-control" id="password" placeholder="Password"    name="password" required="required" />
            </div>
            <div class="form-group text-left" >
              <input type="password" class="form-control" data-parsley-equalto="#password" id="confirm_password" placeholder="Confirm Password"  name="confirm_password" required="required" />
            </div>
            <div class="text-">
              <button class="btn btn-primary form-control submit" type="submit">Save</button>
              
            </div>

            <div class="clearfix"></div>
              <p>
                First Time Login
              </p>
            <div class="separator">

              <div class="clearfix"></div>
              <br />

              <div>
                <h1><i class="fa fa-adn"></i> HRIS</h1>
                <p>©2018 All Rights Reserved. Developed by <a href="https://algermakiputin.com">Alger Makiputin</a></p>
              </div>
            </div>
          </form>
        </section>
  
    </div>
  </body>
 
 
@endsection
