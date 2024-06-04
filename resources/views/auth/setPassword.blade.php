 
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
              <p><br>Note: Password must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters</p>
              <input type="password" class="form-control" id="password" placeholder="Password" name="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" required="required" />
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
                <h1><img src="{{ url('images/logo.png') }}" style="height: 60px;" > HRIS</h1>
              </div>
            </div>
          </form>
        </section>
  
    </div>
  </body>
 
 
@endsection
