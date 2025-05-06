<header class="header <?php if (isset($_SESSION["user_id"])) echo 'logged-in'; ?>">
  <div class="triangle-bg"></div>
  <div class="header-content">
    <div class="logo">
      <a href="index.php">
        <img src="chlumeclogo.png" alt="Warriors Logo">
      </a>
    </div>
    <nav class="menu-container">
      <ul class="menu">
        <li><a href="soupisky.php">Soupiska</a></li>
        <li><a href="zapasy.php">Zápasy</a></li>
        <li><a href="aktuality.php">Aktuality</a></li>
        <li><a href="multimedia.php">Fotogalerie</a></li>
        <li><a href="klubova-historie.php">Klub</a></li>
        <?php if (isset($_SESSION["user_id"])): ?>
          <li><a href="profil.php">Profil</a></li>
          <li><a href="logout.php">Odhlásit</a></li>
        <?php else: ?>
          <li><a href="login.php">Přihlášení</a></li>
        <?php endif; ?>
      </ul>
    </nav>
    <div class="menu-toggle">&#9776;</div>
  </div>
</header>

<style>
  * {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
  }

  body {
    font-family: system-ui, sans-serif;
  }

  .header {
    position: relative;
    height: 100px;
    z-index: 1000;
    color: white;
    width: 100%;
    transition: all 0.3s ease;
  }

  .triangle-bg {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%; /* opraveno z 150% */
  height: 100px;
  background: linear-gradient(115deg, #d32f2f 30%, #000 30%);
  clip-path: polygon(0 0, 100% 0, 100% 100%, 0 100%);
  z-index: -1;
  animation: fadeInDown 1s ease-out;
}

.header.logged-in .triangle-bg {
  height: 100px;
  /* odstraněn transform: translateX(-3%) */
}


  .header-content {
    max-width: 1200px;
    margin: 0 auto;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0 20px;
  }

  .logo img {
    max-width: 120px;
    height: auto;
    animation: fadeInLeft 1s ease-out;
  }

  .menu-container {
    display: flex;
    z-index: 999;
  }

  .menu {
    display: flex;
    gap: 20px;
    list-style: none;
    margin: 0;
    padding: 0;
  }

  .menu li a {
    color: white;
    text-decoration: none;
    font-weight: 500;
    padding: 8px 14px;
    border-radius: 5px;
    transition: all 0.3s ease;
    position: relative;
  }

  .menu li a:hover {
    background-color: rgba(255, 255, 255, 0.15);
    transform: translateY(-2px);
  }

  .menu-toggle {
    display: none;
    font-size: 28px;
    cursor: pointer;
    color: white;
    z-index: 1001;
  }

  @media (max-width: 768px) {
    .menu-toggle {
      display: block;
    }

    .menu-container {
      display: none;
      flex-direction: column;
      position: absolute;
      top: 100px;
      left: 0;
      width: 100%;
      background-color: #000;
      padding: 15px 0;
      z-index: 1000;
    }

    .menu-container.active {
      display: flex;
    }

    .menu {
      flex-direction: column;
      align-items: center;
      gap: 10px;
    }
  }

  @keyframes fadeInDown {
    from {
      transform: translateY(-100%);
      opacity: 0;
    }
    to {
      transform: translateY(0);
      opacity: 1;
    }
  }

  @keyframes fadeInLeft {
    from {
      transform: translateX(-50px);
      opacity: 0;
    }
    to {
      transform: translateX(0);
      opacity: 1;
    }
  }
</style>

<script>
  document.addEventListener("DOMContentLoaded", () => {
    const toggle = document.querySelector(".menu-toggle");
    const menu = document.querySelector(".menu-container");

    toggle.addEventListener("click", () => {
      menu.classList.toggle("active");
    });

    document.querySelectorAll(".menu a").forEach(link => {
      link.addEventListener("click", () => {
        if (window.innerWidth <= 768) {
          menu.classList.remove("active");
        }
      });
    });
  });
</script>
