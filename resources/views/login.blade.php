<!DOCTYPE html>
<html>
<head>
    <title>Статистик мэдээ</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="card shadow p-4" style="width: 350px;">
        <h3 class="text-center mb-4">Статистик мэдээ</h3>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="mb-3">
                <label>Хэрэглэгчийн нэр:</label>
                <input type="text" name="username" value="{{ old('username') }}" class="form-control" required autofocus>
                @error('username')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label>Нууц үг:</label>
                <input type="password" name="password" class="form-control" required>
            </div>

            <button class="btn btn-primary w-100">Нэвтрэх</button>
        </form>
    </div>
</div>

</body>
</html>