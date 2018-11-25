@extends('layouts.app')

@section('content')

  <body class="login">
    <div>
      <a class="hiddenanchor" id="signup"></a>
      <a class="hiddenanchor" id="signin"></a>

      <div class="login_wrapper">
        <div class="animate form login_form">
          <section class="login_content">
            <form autocomplete="off" method="POST" action="{{ url('validate-account') }}" id="activate">
                @csrf
              <h1>Setup Account </h1>
               <input autocomplete="false" name="hidden" type="text" style="display:none;">
              <div class="form-group text-left">
                <input type="email" required="required" class="form-control" id="email" placeholder="Email" required=""  name="email" />
                 @if (session()->has('email'))
                  <span class="invalid-feedback text-danger" role="alert">
                      <strong>{{ session()->get('email') }}</strong>
                  </span>
              @endif
              </div>
             
              <div class="form-group"> 
                <button class="btn btn-info submit form-control" type="submit">Submit</button>
               
              </div>
              
              <div class="clearfix"></div>

              <div class="separator">
                  <a href="{{ url('login') }}">Login</a>
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
