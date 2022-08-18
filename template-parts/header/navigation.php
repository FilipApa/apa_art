<nav class="navbar navbar-expand-lg navbar-light">
  <div class="container-fluid ">
    <a class="navbar-brand" href="<?php echo home_url() ?>">Apaart</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
      <ul class="navbar-nav mb-2 mb-lg-0">
        <li class="nav-item mx-1">
          <a class="nav-link" href="#">About</a>
        </li>
        <li class="nav-item mx-1 dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Art
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="<?php echo site_url( 'category/paintings/') ?>">Paintings</a></li>
            <li><a class="dropdown-item" href="<?php echo site_url( 'category/digital-art/') ?>">Digiral Art</a></li>
            <li><a class="dropdown-item" href="<?php echo site_url( 'category/music/') ?>">Music</a></li>
          </ul>
        </li>
        <li class="nav-item mx-1">
          <a class="nav-link" href="#">Contact</a>
        </li>
      </ul>
    </div>
  </div>
</nav>