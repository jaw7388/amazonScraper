@extends('layouts.auth')

@section('content')

<body class="hold-transition login-page">
    <div class="login-box">
      <div class="login-logo">
        <a href="{{ route('login') }}"><b>Admin</b>LTE</a>
      </div>
        <div class="card">
            <div class="card-header">{{ __('Reset Password') }}</div>

            <div class="card-body">
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('password.email') }}">
                    @csrf

                    <div class="input-group mb-3">
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="{{ __('E-Mail Address') }}">
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        <div class="input-group-append">
                            <div class="input-group-text">
                              <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-12">
                        <button type="submit" class="btn btn-primary  btn-block">
                            {{ __('Send Password Reset Link') }}
                        </button>
                        </div>
                        <!-- /.col -->
                    </div>
                    <a href="{{ route('login') }}" class="text-center">Login</a>
                    </form>
            </div>
        </div>
    </div>
</body>

@endsection
