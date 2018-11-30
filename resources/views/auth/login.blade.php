@extends('layouts.app')

@section('content')

  <body class="login">
    <div>
      <a class="hiddenanchor" id="signup"></a>
      <a class="hiddenanchor" id="signin"></a>

      <div class="login_wrapper">
        <div class="animate form login_form">
          <section class="login_content">
            <form autocomplete="off" id="login" method="POST" action="{{ route('login') }}" aria-label="{{ __('Login') }}">
                @csrf
              <h1>Login </h1>
               <input autocomplete="false" name="hidden" type="text" style="display:none;">
              <div class="form-group text-left">
                <input type="email" required="required" class="form-control" id="email" placeholder="email" required=""  name="email" />
                @if ($errors->has('email'))
                    <span class="invalid-feedback text-danger" role="alert">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
              </div>
              <div class="form-group text-left">
                <input type="password" required="required" class="form-control" id="password" placeholder="password" required="" name="password" />
                @if ($errors->has('password'))
                    <span class="invalid-feedback text-danger" role="alert">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                @endif
              </div>
              <div>
                <button class="btn btn-info submit form-control" type="submit" id="login-btn">Log in</button>
               
              </div>
              
              <div class="clearfix"></div>

              <div class="separator">
                  <a href="{{ url('activate-account') }}">First time login?</a>
                <div class="clearfix"></div>
                <br />

                <div>
                  <h1><i class="fa fa-adn"></i> HRIS</h1>
                  <p>©2018. Developed by <a href="https://algermakiputin.com">Alger Makiputin</a></p>
                </div>
              </div>
            </form>
          </section>
        </div>

       
      </div>
    </div>
  </body>
 
 
@endsection
