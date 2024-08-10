  <!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">

<ul class="sidebar-nav" id="sidebar-nav">

  <li class="nav-item">
    <a class="nav-link " href="{{route('admin.dashboard')}}">
      <i class="bi bi-grid"></i>
      <span>Dashboard</span>
    </a>
  </li><!-- End Dashboard Nav -->

 <li class="nav-item">
    <a class="nav-link collapsed" data-bs-target="#forms-nav" data-bs-toggle="collapse" href="{{route('products.create')}}">
      <i class="bi bi-journal-text"></i><span>Products</span><i class="bi bi-chevron-down ms-auto"></i>
    </a>
    <ul id="forms-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
      <li>
        <a href="{{route('products.create')}}">
          <i class="bi bi-circle"></i><span>Add Product</span>
        </a>
      </li>
      <li>
        <a href="{{route('products.index')}}">
          <i class="bi bi-circle"></i><span>Product Lists</span>
        </a>
      </li>
  
    </ul>
  </li><!-- End Forms Nav -->

  <li class="nav-heading">Activity</li>

<li class="nav-item">
  <a class="nav-link collapsed" href="users-profile.html">
    <form action="{{ route('logout') }}" method="POST" style="display: inline;">
            @csrf
            <button type="submit" class="dropdown-item d-flex align-items-center">
            <i class="bi bi-box-arrow-right"></i>
            <span>Sign Out</span>
            </button>
        </form>
  </a>
</li><!-- End Logout Page Nav -->





  
</ul>

</aside><!-- End Sidebar-->
