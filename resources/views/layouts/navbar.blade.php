<nav class="navbar navbar-expand-lg navbar-light bg-light mb-4">
  <div class="container">
    <a class="navbar-brand" href="{{ url('/') }}">نظام الحضور</a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item">
          <a class="nav-link" href="{{ route('students.index') }}">الطلاب</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ route('students.create') }}">إضافة طالب</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ route('attendance.index') }}">الحضور</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ route('attendance.scanPage') }}">مسح QR</a>
        </li>
          <li class="nav-item">
        <a class="nav-link" href="{{ route('students.cards') }}">🎫 طباعة الكرنيهات</a>
      </li>
      </ul>
    </div>
  </div>
</nav>
