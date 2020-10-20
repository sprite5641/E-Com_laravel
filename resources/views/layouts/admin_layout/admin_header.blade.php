<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="{{ url('/admin/dashboard')}}" class="nav-link">หน้าหลัก</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="{{ url('http://www.facebook.com/sprite.5641') }}" class="nav-link">ติดต่อ</a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <a title="Logout" href="javascript:void(0)" class="confirmLogout">
          <i class="fas fa-sign-out-alt"></i>
          ออกจากระบบ
        </a> 
        </a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->