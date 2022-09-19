<nav class="navbar ">
  <div class="navbar-fluid">
    <a class="navbar-brand" href="<?php echo home_url() ?>">Apaart</a>
    <button class="navbar-toggler" type="button" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="navbar-collapse" >
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" href="#">About</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" >
            Art
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="<?php echo site_url( 'category/paintings/' ) ?>">Paintings</a></li>
            <li><a class="dropdown-item" href="<?php echo site_url( 'category/digital-art/' ) ?>">Digiral Art</a></li>
            <li><a class="dropdown-item" href="<?php echo site_url( 'category/music/' ) ?>">Music</a></li>
          </ul>
        </li>
        <li class="nav-item ">
          <a class="nav-link" href="#">Contact</a>
        </li>
      </ul>
    </div>
  </div>
</nav>