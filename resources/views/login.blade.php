<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;300;400;600;700&display=swap">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            margin: 0;
            padding: 0;
            display: flex;
            height: 100vh;
            align-items: center;
            justify-content: center;
            background-color: #fff;
            font-family: 'Nunito', sans-serif;
        }

        .container {
            background-color: #ffffff;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
            overflow: hidden;
            width: 100%;
            max-width: 480px;
        }

        .header-image {
            height: 150px;
            background: url("{{ asset('images/signin.png') }}") no-repeat center center;
            background-size: cover;
        }

        .content {
            padding: 40px;
            padding-top: 0px;
            text-align: center;
        }

        .content img {
            width: 100px;
        }

        .content h1 {
            color: #333;
            font-weight: 700;
            margin-bottom: 8px;
        }

        .content p {
            color: #666;
            font-size: 15px;
            margin-bottom: 24px;
        }

        .form-group {
            text-align: left;
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            font-weight: 600;
            color: #444;
            margin-bottom: 6px;
        }

        .form-control {
            width: 100%;
            padding: 12px;
            border: 2px solid #ddd;
            border-radius: 8px;
            transition: border 0.3s;
        }

        .form-control:focus {
            border-color: #4b0082;
            outline: none;
            box-shadow: 0 0 8px rgba(75, 0, 130, 0.2);
        }

        .btn-primary {
            background-color: #4b0082;
            color: #fff;
            padding: 12px 0;
            border: none;
            width: 100%;
            border-radius: 30px;
            cursor: pointer;
            font-weight: 700;
            transition: background 0.3s;
        }

        .btn-primary:hover {
            background-color: #3a006e;
        }

        .footer {
            margin-top: 20px;
            font-size: 14px;
            color: #666;
        }

        .footer a {
            color: #4b0082;
            text-decoration: none;
            font-weight: 600;
        }

        .footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header-image"></div>
        <div class="content">
            <img src="{{ asset('images/logo.png') }}" alt="Company Logo">
            <h1>Welcome Back!</h1>
            <p>Log Into Your Account</p>
            <form action="{{ route('login') }}" method="POST">
                @csrf
            
                <div class="form-group">
                    <label for="email">Email</label>
                    <input 
                        type="email" 
                        name="email" 
                        id="email" 
                        class="form-control @error('email') is-invalid @enderror" 
                        placeholder="Enter email..." 
                        value="{{ old('email') }}"
                    >
                    @error('email')
                    <div class="invalid-feedback" style="color: red; font-size: 14px;">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            
                <div class="form-group">
                    <label for="password">Password</label>
                    <input 
                        type="password" 
                        name="password" 
                        id="password" 
                        class="form-control @error('password') is-invalid @enderror" 
                        placeholder="Enter password..."
                    >
                    @error('password')
                    <div class="invalid-feedback" style="color: red; font-size: 14px;">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            
                @if(session('error'))
                <div class="alert alert-danger" style="margin-top: 15px;">
                    {{ session('error') }}
                </div>
                @endif
            
                <button type="submit" class="btn-primary">LOGIN</button>
            </form>
            
            <div class="footer">
                <a href="#">FORGOT YOUR PASSWORD?</a>
                <br>
                Don't Have An Account? <a href="{{ route('register') }}">SIGN UP</a>
            </div>
        </div>
    </div>
</body>

</html>
