<nav class="navbar navbar-expand-md <?php echo theme('navbar-dark', 'navbar-light') ?>">
    <div class="container-fluid">
        <button class="navbar-toggler ms-auto ms-md-2" type="button" data-bs-toggle="collapse" data-bs-target="#navbar">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbar">
            <ul class="navbar-nav align-items-center <?php echo theme('bg-dark','bg-white') ?>">
                <li class="nav-item">
                    <a class="nav-link <?php echo theme('text-light', 'text-primary') ?>" href="/">Index</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo theme('text-light', 'text-primary') ?>" href="/users">Users</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo theme('text-light', 'text-primary') ?>" href="/about">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo theme('text-light', 'text-primary') ?>" href="/contact">Contact</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo theme('text-light', 'text-primary') ?>" href="#" onclick="toggleDarkMode()">Dark Mode</a>
                </li>
            </ul>
        </div>
    </div>
</nav>