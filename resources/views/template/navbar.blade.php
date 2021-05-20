<nav class="main-header navbar navbar-expand navbar-white navbar-light">
{{-- Navbar Kiri --}}
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="/" class="nav-link">Home</a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="#" class="nav-link">Role : {{ Auth::user()->getRoleNames()[0] }}</a>
        </li>
        {{-- <li class="nav-item d-none d-sm-inline-block">
            <a href="#" class="nav-link">ID : {{ Auth::user()->id }}</a>
        </li> --}}
    </ul>

{{-- Navbar Kanan --}}
    <ul class="navbar-nav ml-auto">
    @can('adminTU')
        <li class="nav-item">
            <a href="{{ route('setting') }}" class="nav-link">Setting</a>
        </li>  
    @endcan
        <li class="nav-item">
            <a href="#" class="nav-link">Name: {{ Auth::user()->name }}</a>
        </li>
        <li class="nav-item">
            <a href="{{ route('logout') }}" class="nav-link" 
                onclick="event.preventDefault(); 
                document.getElementById('logout-form').submit();" >
                Logout
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
            </form>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                <i class="fas fa-expand-arrows-alt"></i>
            </a>
        </li>
    </ul>
</nav>