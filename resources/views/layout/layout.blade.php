<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="{{ asset('build/assets/app.css') }}">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
                <!--<h1>Welcome, {{ Auth::user()->name }}!</h1>
                <p>You are now logged in to your account.</p>

                <form action="/logout" method="POST">
                    @csrf
                    <button>Logout</button>
                </form>-->
<div class="dashboard">
    <div class="sidebar">
        <i class='bx bx-menu' id="menu-btn" style="font-size: 2rem; cursor: pointer;"></i>
        <div class="top">
            <div class="logo">
                <img src="../images/linear.png" height="35px" width="130px">
            </div>
            
        </div>
        <div class="tpro">
            <h2>TenantPro</h2>
        </div>
        <ul>
            <li>
                <a href="#">
                    <i class="bx bx-layout"></i>
                    <span class="nav-item">Dashboard</span>
                </a>
            </li>

            <li>
                <a href="#">
                    <i class="bx bx-wallet"></i>
                    <span class="nav-item">Finances</span>
                </a>
            </li>

            <li>
                <a href="#">
                    <i class="bx bx-file"></i>
                    <span class="nav-item">Documents</span>
                </a>
            </li>

            <li>
                <a href="#">
                    <i class="bx bx-help-circle"></i>
                    <span class="nav-item">Help</span>
                </a>
            </li>

            <li>
                <a href="#">
                    <i class="bx bx-briefcase"></i>
                    <span class="nav-item">Maintenance</span>
                </a>
            </li>

            <li>
                <a href="#">
                    <i class="bx bx-book-open"></i>
                    <span class="nav-item">Announcements</span>
                </a>
            </li>
        </ul>
                        <!--<form action="/logout" method="POST">
                                @csrf
                                <button>Logout</button>
                            </form>-->
        <div class="user">
            <div class="user-mini" onclick="toggleUserPopup()">
                <img src="{{ Auth::user()->profile_photo 
                            ? asset('profile_photos/' . Auth::user()->profile_photo)
                            : asset('default-pfp.png') }}"
                    class="mini-pfp">

                <span class="mini-name">{{ Auth::user()->name }}</span>
            </div>

            <!-- POPUP -->
            <div class="user-popup" id="userPopup">
                <div class="popup-header">
                    <img src="{{ Auth::user()->profile_photo 
                                ? asset('profile_photos/' . Auth::user()->profile_photo)
                                : asset('default-pfp.png') }}"
                        class="popup-pfp">

                    <h3>{{ Auth::user()->name }}</h3>
                    <p>{{ Auth::user()->email }}</p>
                </div>
                <a href="{{ route('settings') }}" class="popup-settings-btn">Settings</a>
                <form action="/logout" method="POST" id="signoutspec">
                    @csrf
                    <button class="popup-logout">Sign out</button>
                </form>
            </div>  
        </div>
    </div>
    <div class="main-content">
        @yield('content')
    </div>
</div>


<script>
function toggleUserPopup() {
    const popup = document.getElementById('userPopup');
    popup.style.display = popup.style.display === 'block' ? 'none' : 'block';
}

// close popup when clicking outside
document.addEventListener('click', function(e) {
    const popup = document.getElementById('userPopup');
    const userBtn = document.querySelector('.user-mini');

    if (!popup.contains(e.target) && !userBtn.contains(e.target)) {
        popup.style.display = 'none';
    }
});

const menuBtn = document.getElementById('menu-btn');
const sidebar = document.querySelector('.sidebar');

menuBtn.addEventListener('click', () => {
    sidebar.classList.toggle('active');
});

// Optional: click outside to close
document.addEventListener('click', function(e) {
    if (!sidebar.contains(e.target) && !menuBtn.contains(e.target)) {
        sidebar.classList.remove('active');
    }
});

</script> 
</body>
</html>