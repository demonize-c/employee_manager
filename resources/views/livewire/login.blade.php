
@section('css')  
  <style>
    body, html {
      height: 100%;
      margin: 0;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background-color: #f1f5f9;
    }

    .login-container {
      height: 100%;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 15px;
    }

    .login-box {
      width: 100%;
      max-width: 400px;
      background-color: white;
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }

    .login-box h2 {
      margin-bottom: 20px;
    }

    .form-control:focus {
      border-color: #10b981;
      box-shadow: 0 0 0 0.2rem rgba(16, 185, 129, 0.25);
    }

    .btn-primary {
      background-color: #10b981;
      border: none;
    }

    .btn-primary:hover {
      background-color: #0e9e6e;
    }

    @media (max-width: 576px) {
      .login-box {
        padding: 20px;
        border-radius: 8px;
      }
    }
  </style>
@endsection
<div class="login-container">
    <div class="login-box">
      <h2 class="text-center">Login</h2>
      <form >
      <!-- <div class="mb-3">
         <div class="alert alert-danger">
             ll
         </div>
      </div> -->
        <div class="mb-3">
          <label for="email" class="form-label">Email address</label>
          <input type="email" class="form-control" id="email" placeholder="Enter email or username" wire:model="username">
          @error('username')
              <small class="text-danger">{{$message}}</small>
          @enderror
        </div>
        <div class="mb-3">
          <label for="password" class="form-label">Password</label>
          <input type="password" class="form-control" id="password" placeholder="Password" wire:model="password">
          @error('password')
              <small class="text-danger">{{$message}}</small>
          @enderror
        </div>
        <div class="mb-3 form-check">
          <input type="checkbox" class="form-check-input" id="remember" wire:model="remember">
          <label class="form-check-label" for="remember">Remember me</label>
        </div>
        <div class="mb-3">
            @if(session('status'))
               <small class="text-danger"> {{ session('status')}}</small>
            @endif
        </div>

        <button type="button"  class="btn btn-primary w-100" wire:click="login">Login</button>
      </form>
    </div>
</div>
