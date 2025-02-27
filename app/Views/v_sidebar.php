<?= $this->include('v_header') ?>

<body>
  <div class="wrapper">
    <!-- Sidebar -->
    <aside id="sidebar">
      <div class="h-100">
        <div class="sidebar-logo">
          <a href="#">Dashboard</a>
        </div>
        <!-- Sidebar Navigation -->
        <ul class="sidebar-nav">
          <li class="sidebar-item">
            <a href='<?= getURL('user') ?>' class="sidebar-link">
              <i class="fa-solid fa-list pe-2"></i>
              Master User
            </a>
          </li>
          <li class="sidebar-item">
            <a href='<?= getURL('city') ?>' class="sidebar-link">
              <i class="fa-solid fa-list pe-2"></i>
              Master City
            </a>
          </li>
          <li class="sidebar-item">
            <a href='<?= getURL('ekspedition') ?>' class="sidebar-link">
              <i class="fa-solid fa-list pe-2"></i>
              Master Ekspedition
            </a>
          </li>
          <li class="sidebar-item">
            <a href='<?= getURL('province') ?>' class="sidebar-link">
              <i class="fa-solid fa-list pe-2"></i>
              Master Province
            </a>
          </li>
          <li class="sidebar-item">
            <a href='<?= getURL('category') ?>' class="sidebar-link">
              <i class="fa-solid fa-list pe-2"></i>
              Master Category
            </a>
          </li>
          <li class="sidebar-item">
            <a href='<?= getURL('type') ?>' class="sidebar-link">
              <i class="fa-solid fa-list pe-2"></i>
              Master Type
            </a>
          </li>
        </ul>
      </div>
    </aside>
    <!-- Main Component -->
    <div class="main">
      <nav class="navbar navbar-expand px-3 border-bottom">
        <!-- Button for sidebar toggle -->
        <button class="btn" type="button" data-bs-theme="dark">
          <span class="navbar-toggler-icon"></span>
        </button>
      </nav>
      <?= $this->renderSection('content') ?>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  <script>
    const toggler = document.querySelector(".btn");
    toggler.addEventListener("click", function() {
      document.querySelector("#sidebar").classList.toggle("collapsed");
    });
  </script>
  
</body>