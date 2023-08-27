@extends('layout')

@section('content')

<main class="login-form">
  <div class="cotainer">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">Reset Password</div>
          <div class="card-body">
            
            <form action="{{ url('auth/reset-password') }}" id="reset-form" method="POST">
             
              <input type="hidden" name="token" value="{{ $token }}">
              
              <div class="form-group row">
                <label for="email_address" class="col-md-4 col-form-label text-md-right">E-Mail Address</label>
                <div class="col-md-6">
                  <input type="text" id="email" class="form-control" name="email" autofocus>

                  <span class="text-danger email_error"></span>
                </div>
              </div>
              
              <div class="form-group row">
                <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>
                <div class="col-md-6">
                  <input type="password" id="password" class="form-control" name="password" required>
                  @error('password')
                  <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                  @enderror
                  <span class="text-danger password_error"></span>
                  
                </div>
              </div>
              
              <div class="form-group row">
                <label for="password-confirm" class="col-md-4 col-form-label text-md-right">Confirm Password</label>
                <div class="col-md-6">
                  <input type="password" id="password_confirmation" class="form-control" name="password_confirmation" required>
                  @error('password_confirmation')
                  <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                  @enderror
                  
                  
                </div>
              </div>
              
              <div class="col-md-6 offset-md-4">
                <button type="submit" class="btn btn-primary btn-submit">
                  Reset Password
                </button>
              </div>
            </form>
            
          </div>
        </div>
      </div>
    </div>
  </div>
</main>


<script>

  $("#reset-form").validate({
   
    rules: {
      email: {
        required: true,
        email: true
      },
      
      password: {
        required: true,
        minlength: 6

      },

      password_confirmation: {
        required: true,
        minlength: 6,
        equalTo: "#password"

      },
      
      
    },
    messages: {
     
      email: {
        required: "Please enter Email",
      },
      password: {
        required: "Please enter valid password",
      },
      password_confirmation: {
        required: "Please enter password again",
        equalTo: "Password should match with confirm password"
      },
    },
  })

</script>



@endsection