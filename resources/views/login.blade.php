<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    <link href="{{ asset('assets/cdn/bootstrap.min.css') }}" rel="stylesheet">
    <script src="{{ asset('assets/cdn/bootstrap.min.js') }}"></script>
</head>

<body>
    <main class="d-flex justify-content-center align-items-center vh-100">
        <form action="{{ route('login') }}" method="POST">
            @csrf
            <div class="container vw-100">
                <div class="form-group">
                    <label for="exampleInputEmail1">Email address</label>
                    <input name="email" type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"
                        placeholder="Enter email">
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Password</label>
                    <input name="password" type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
                </div>
                <button type="submit" class="btn btn-primary my-2">Submit</button>
            </div>
        </form>
    </main>
</body>

</html>
