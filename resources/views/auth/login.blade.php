<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container">
    <div class="row justify-content-center align-items-center vh-100">
        <div class="col-md-4">

            <div class="card shadow">
                <div class="card-body">
                    <h3 class="text-center mb-4">Login</h3>

                    <form method="POST" action="{{ route('frontend-authenticate') }}">
                        @csrf

                        <div class="mb-3">
                            <input
                                type="email"
                                name="email"
                                class="form-control"
                                placeholder="Email"
                                value="{{ old('email') }}"
                            >
                            @error('email')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <input
                                type="password"
                                name="password"
                                class="form-control"
                                placeholder="Password"
                                
                            >
                            @error('password')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="d-grid mb-3">
                            <button type="submit" class="btn btn-primary">
                                Login
                            </button>
                        </div>
                    </form>

                    <div class="text-center">
                        <p class="mb-2">Don't have an account?</p>

                        <a href="{{ route('frontend-register') }}" class="btn btn-success">
                            Register
                        </a>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>

</body>
</html>