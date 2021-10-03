<header>
  <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark bg-blue px-5"
       style="background-color: #172d56!important">
    <a href="{{ url('/home') }}" class="navbar-brand">Trang chủ</a>
    <div class="collapse navbar-collapse d-flex justify-content-between">
      <ul class="navbar-nav">
        <li class="navbar-item">
          <a href="{{ url('/forms/faculty') }}" class="{{ $nav1_class ?? 'nav-link' }}">Khoá - Khoa - Lớp</a>
        </li>
        <li class="navbar-item">
          <a href="{{ url('/forms/module-class') }}" class="{{ $nav2_class ?? 'nav-link' }}">Lớp học phần</a>
        </li>
        <li class="navbar-item">
          <a href="{{ url('/delete-notification') }}" class="{{ $nav3_class ?? 'nav-link' }}">Xóa thông
            báo</a>
        </li>
        <li class="navbar-item">
          <a href="{{ url('/import-data') }}" class="{{ $nav4_class ?? 'nav-link' }}">Nhập dữ liệu</a>
        </li>
      </ul>

      <div class="dropdown">
        <button type="button"
                class="btn btn-secondary dropdown-toggle"
                data-bs-toggle="dropdown"
                aria-expanded="false"
                id="dropdownMenuButton">
          {{ session('username') }}
        <i class="fas fa-cogs"></i>
        <input type="hidden" name="id_" value="{{ session('id') }}"/>
        </button>

        <ul class="dropdown-menu mr-5" aria-labelledby="dropdownMenuButton">
          <li><a href="" class="dropdown-item">Cài đặt</a></li>
          <li>
            <hr class="dropdown-divider">
          </li>
          <li><a href="{{ url('/logout')}}" class="dropdown-item">Đăng xuất</a></li>
        </ul>
      </div>
    </div>
  </nav>
</header>
<div class="mt-4 mb-4" style="height: 50px"></div>
