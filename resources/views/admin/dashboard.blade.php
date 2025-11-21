<h1>Dashboard Admin</h1>
<div class="sidebar-bottom">
    <hr class="sidebar-divider">
    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-purple w-100 mt-2">
            <i class="fa-solid fa-right-to-bracket me-2"></i>Logout
        </button>
    </form>
</div>