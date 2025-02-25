<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIl14JGDhS7nauLaF1F1TkH8pqiv/aW25307StakicSUAzYyR15A6PsrvE8BI1tVPSXn5z" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css"
    rel="stylesheet"
    integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ"
    crossorigin="anonymous" />
  <link rel="stylesheet" href="public/css/style.css" />
  <title>Sidebar With Bootstrap</title>
</head>

<body>
  <div class="wrapper">
    <!-- Sidebar -->
    <aside id="sidebar">
      <div class="h-100">
        <div class="sidebar-logo">
          <a href="#">CodzSword</a>
        </div>
        <!-- Sidebar Navigation -->
        <ul class="sidebar-nav">
          <li class="sidebar-header d-flex justify-content-center">Master...</li>
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

</html>