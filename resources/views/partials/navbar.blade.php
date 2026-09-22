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
    </ul>
</nav>