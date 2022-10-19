<nav class="navbar">
    <a class="nav-logo" href="<?php echo home_url() ?> ">Apaart</a>
   
      <ul class="nav">
        <li class="nav-item">
          <a class="nav-link" href="#">About</a>
        </li>
        <li class="nav-item relative">
          <a class="nav-link" href="#" id="nav-dropdown" role="button">
            Art  <img src=" <?php echo get_theme_file_uri( './assets/images/arrow-down.svg') ?>" alt="Arrow down icon">
          </a>
          <ul class="nav-dropdown-menu dropdown" aria-label="Toggle dropdown">
            <li class="nav-item"><a class="nav-link" href="<?php echo site_url( 'category/paintings/' ) ?>">Paintings</a></li>
            <li class="nav-item"><a class="nav-link" href="<?php echo site_url( 'category/digital-art/' ) ?>">Digiral Art</a></li>
            <li class="nav-item"><a class="nav-link" href="<?php echo site_url( '3d-animations' ) ?>">3D Animations</a></li>
          </ul>
        </li>
        <li class="nav-item ">
          <a class="nav-link" href="#">Contact</a>
        </li>
      </ul>
</nav>