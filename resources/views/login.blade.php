<!doctype html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <script src="https://kit.fontawesome.com/9ed593a796.js" crossorigin="anonymous"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
  <title>Đăng nhập</title>
  <link rel="stylesheet" href="{{url('css/login/style.css')}}">
</head>

<body class="text-center cc_cursor bg-light">
<form method="post"
      action="{{url('/auth/authenticate')}}"
      class="form-signin cc_cursor border border-dark mb-4 rounded">
  @csrf
  <div class="mt-3 mb-3">
    <div class="input-group">
        <span class="col-lg-1 justify-content-center align-items-center d-flex">
          <i class="fas fa-user d-block"></i>
        </span>
      <label>
        <input type="text"
               name="username"
               class="form-control cc_cursor rounded"
               placeholder="Tên đăng nhập">
      </label>
    </div>
  </div>

  <div class="mb-3">
    <div class="input-group">
        <span class="col-lg-1 justify-content-center align-items-center d-flex">
          <i class="fas fa-key"></i>
        </span>
      <label>
        <input type="password"
               name="password"
               class="form-control cc_cursor rounded"
               placeholder="Mật khẩu">
      </label>
    </div>
  </div>
  <button class="mb-3 btn btn-primary" type="submit" name="btn-submit">Đăng nhập</button>

  @if (isset($_GET['status']))
    <p class="text-danger">Đăng nhập thất bại</p>
  @endif
</form>

<script src="{{ url('js/login/script.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW"
        crossorigin="anonymous"></script>
</body>
</html>
