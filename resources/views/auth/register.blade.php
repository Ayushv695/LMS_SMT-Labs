<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container">
    <div class="row justify-content-center align-items-center vh-100">
        <div class="col-md-5">

            <div class="card shadow">
                <div class="card-body">

                    <h3 class="text-center mb-4">Register</h3>

                    <form method="POST" action="{{ route('frontend-registration') }}">
                        @csrf

                        <div class="mb-3">
                            <input type="text" name="name"
                                   class="form-control"
                                   placeholder="Name"
                                   value="{{ old('name') }}"
                                   >
                            @error('name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <input type="email" name="email"
                                   class="form-control"
                                   placeholder="Email"
                                   value="{{ old('email') }}"
                                   >
                            @error('email')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <input type="password" name="password"
                                   class="form-control"
                                   placeholder="Password"
                                   >
                            @error('password')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <input type="password" name="password_confirmation"
                                   class="form-control"
                                   placeholder="Confirm Password"
                                   >
                            @error('password_confirmation')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-success">
                                Register
                            </button>
                        </div>
                    </form>

                    <div class="text-center mt-3">
                        <a href="{{ route('frontend-login') }}">Already have an account? Login</a>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>

</body>
</html>