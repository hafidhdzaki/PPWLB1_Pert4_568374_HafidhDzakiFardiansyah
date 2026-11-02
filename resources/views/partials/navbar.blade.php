<nav style="background-color: #333; padding: 15px 30px; display: flex; justify-content: space-between; align-items: center;">

    <div>
        <a href="{{ route('home') }}" style="color: #fff; text-decoration: none; font-size: 1.5rem; font-weight: bold;">
            Portofolio
        </a>
    </div>

    <ul style="list-style: none; display: flex; gap: 20px; margin: 0; padding: 0;">
        <li>
            <a href="{{ route('home') }}" style="color: #fff; text-decoration: none;">Home</a>
        </li>
        <li>
            <a href="{{ route('about') }}" style="color: #fff; text-decoration: none;">About</a>
        </li>
        <li>
            <a href="{{ route('education') }}" style="color: #fff; text-decoration: none;">Education</a>
        </li>
        <li>
            <a href="{{ route('projects.index') }}" style="color: #fff; text-decoration: none;">Projects</a>
        </li>
        @auth
            <li>
                <span style="margin-right: 15px;">Halo, {{ Auth::user()->name }} ({{ strtoupper(Auth::user()->role) }})</span>
                
                <a href="{{ route('profile.show') }}" style="color: white; margin-right: 15px;">Profil Saya</a>
            </li>
            
            <li>
                <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" style="background: none; border: none; color: #ff6b6b; cursor: pointer;">Logout</button>
                </form>
            </li>
        @else
            <li>
                <a href="{{ route('login') }}" style="color: white;">Login</a>
            </li>
        @endauth
    </ul>
</nav>