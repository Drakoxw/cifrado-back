<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
</head>
<body>
    @if ($error)
        <div >
            <div class="fixed-top alert alert-danger" style="width: 400px; top: 4rem; margin:auto" role="alert">
                {{ $error }}
            </div>
        </div>
    @endif
    <main class="login-form h-100">
        <div class="cotainer min-vh-100 d-flex align-items-center justify-content-center">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">Login</div>
                        <div class="card-body">
                            <form action="{{url('/login')}}" method="post">
                                @csrf
                                <div class="form-group row">
                                    <label for="email_address" class="col-4 col-form-label text-right">User</label>
                                    <div class="col-6">
                                        <input type="text" id="user" class="form-control" name="user" required autofocus>
                                    </div>
                                </div>

                                <div class="form-group row mt-3">
                                    <label for="password" class="col-4 col-form-label text-right">Password</label>
                                    <div class="col-6">
                                        <input type="password" id="pass" class="form-control" name="pass" required>
                                    </div>
                                </div>

                                <div class="col-6 offset-4 mt-3">
                                    <button type="submit" class="btn btn-primary" >
                                        Login
                                    </button>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
      </main>
</body>
</html>

