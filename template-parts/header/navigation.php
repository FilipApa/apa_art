<nav class="navbar">
    <a class="nav-brand" href="<?php echo home_url() ?>">Apaart</a>
    <button class="nav-toggler" id="nav-menu-btn" type="button" aria-label="Toggle navigation">
      <span class="nav-toggler-icon"></span>
    </button>
    <div class="nav-collapse dropdown" >
      <ul class="nav-nav">
        <li class="nav-item">
          <a class="nav-link" href="#">About</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="nav-dropdown" role="button">
            Art
          </a>
          <ul class="nav-dropdown-menu dropdown" aria-label="Toggle dropdown">
            <li class="nav-item"><a class="nav-link" href="<?php echo site_url( 'category/paintings/' ) ?>">Paintings</a></li>
            <li class="nav-item"><a class="nav-link" href="<?php echo site_url( 'category/digital-art/' ) ?>">Digiral Art</a></li>
            <li class="nav-item"><a class="nav-link" href="<?php echo site_url( 'category/music/' ) ?>">Music</a></li>
          </ul>
        </li>
        <li class="nav-item ">
          <a class="nav-link" href="#">Contact</a>
        </li>
      </ul>
    </div>
</nav>