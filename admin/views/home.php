<div class="container-fluid py-2">
  <div class="row">
    <div class="ms-3">
      <h3 class="mb-0 h4 font-weight-bolder">Home</h3>
      <p class="mb-4">
        Check the sales, value and bounce rate by country.
      </p>
    </div>
    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
      <div class="card">
        <div class="card-header p-2 ps-3">
          <div class="d-flex justify-content-between">
            <div>
              <p class="text-sm mb-0 text-capitalize">Total Money</p>
              <h4 class="mb-0">
              <?php
                if (!empty($total_money)) {
                  foreach ($total_money as $order) {
                    // Kiểm tra nếu giá trị không phải null
                    $total = $order['total_completed_orders'] !== null ? $order['total_completed_orders'] : 0;
                    echo number_format($total, 0, ',', '.') . ' VND';
                  }
                } else {
                  echo '0 VND';
                }
                
              ?>
              </h4>
            </div>
            <div class="icon icon-md icon-shape bg-gradient-dark shadow-dark shadow text-center border-radius-lg">
              <i class="material-symbols-rounded opacity-10">weekend</i>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
      <div class="card">
        <div class="card-header p-2 ps-3">
          <div class="d-flex justify-content-between">
            <div>
              <p class="text-sm mb-0 text-capitalize">Total Users</p>
              <h4 class="mb-0">
                <?= isset($list_user[0]['total']) ? $list_user[0]['total'] : 0 ?>
              </h4>
            </div>
            <div class="icon icon-md icon-shape bg-gradient-dark shadow-dark shadow text-center border-radius-lg">
              <i class="material-symbols-rounded opacity-10">person</i>
            </div>
          </div>
        </div>

      </div>
    </div>
    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
      <div class="card">
        <div class="card-header p-2 ps-3">
          <div class="d-flex justify-content-between">
            <div>
              <p class="text-sm mb-0 text-capitalize">Total Products</p>
              <h4 class="mb-0">
                <?= isset($list_product[0]['total']) ? $list_product[0]['total'] : 0 ?>
              </h4>
            </div>
            <div class="icon icon-md icon-shape bg-gradient-dark shadow-dark shadow text-center border-radius-lg">
              <i class="material-symbols-rounded opacity-10">leaderboard</i>
            </div>
          </div>
        </div>

      </div>
    </div>
    <div class="col-xl-3 col-sm-6">
      <div class="card">
        <div class="card-header p-2 ps-3">
          <div class="d-flex justify-content-between">
            <div>
              <p class="text-sm mb-0 text-capitalize">Sales</p>
              <h4 class="mb-0">$103,430</h4>
            </div>
            <div class="icon icon-md icon-shape bg-gradient-dark shadow-dark shadow text-center border-radius-lg">
              <i class="material-symbols-rounded opacity-10">weekend</i>
            </div>
          </div>
        </div>
        <hr class="dark horizontal my-0">
        <div class="card-footer p-2 ps-3">
          <p class="mb-0 text-sm"><span class="text-success font-weight-bolder">+5% </span>than yesterday</p>
        </div>
      </div>
    </div>
  </div>
  <div class="row">

    <div class="col-lg-4 col-md-6 mt-4 mb-4">
      <div class="card">
        <div class="card-body">
          <h6 class="mb-0">Product Count by Category</h6>
          <p class="text-sm">Displays the count of products in each category</p>
          <div class="pe-2">
            <div class="chart">
              <!-- Thêm phần tử canvas với id="categoryChart" -->
              <canvas id="categoryChart" height="170"></canvas>
            </div>
          </div>
          <hr class="dark horizontal">
          <div class="d-flex">
            <i class="material-symbols-rounded text-sm my-auto me-1">schedule</i>
            <p class="mb-0 text-sm">Updated just now</p>
          </div>
        </div>
      </div>
    </div>

    <div class="col-lg-4 col-md-6 mt-4 mb-4">
      <div class="card ">
        <div class="card-body">
          <h6 class="mb-0 "> Daily Sales </h6>
          <p class="text-sm "> (<span class="font-weight-bolder">+15%</span>) increase in today sales. </p>
          <div class="pe-2">
            <div class="chart">
              <canvas id="chart-line" class="chart-canvas" height="170"></canvas>
            </div>
          </div>
          <hr class="dark horizontal">
          <div class="d-flex ">
            <i class="material-symbols-rounded text-sm my-auto me-1">schedule</i>
            <p class="mb-0 text-sm"> updated 4 min ago </p>
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-4 mt-4 mb-3">
      <div class="card">
        <div class="card-body">
          <h6 class="mb-0 ">Completed Tasks</h6>
          <p class="text-sm ">Last Campaign Performance</p>
          <div class="pe-2">
            <div class="chart">
              <canvas id="chart-line-tasks" class="chart-canvas" height="170"></canvas>
            </div>
          </div>
          <hr class="dark horizontal">
          <div class="d-flex ">
            <i class="material-symbols-rounded text-sm my-auto me-1">schedule</i>
            <p class="mb-0 text-sm">just updated</p>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="row mb-4">
    <div class="col-lg-8 col-md-6 mb-md-0 mb-4" style="overflow: hidden;">
      <div class="card" style="overflow: hidden;">
        <div class="card-header pb-0">
          <div class="row">
            <div class="col-lg-6 col-7">
              <h6>Earth</h6>
            </div>
          </div>
        </div>
        <div class=" px-0 pb-2">
          <div class="card bg-black" style=" object-fit: cover; align-items:last baseline; width: 840px; height: 500px; justify-content: center;">
            <img src="../assets/img/earth.svg" alt="" style="width: 1200px; height: 790px">
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-4 col-md-6">
      <div class="card h-100">
        <div class="card-header pb-0">
          <h6>Orders overview</h6>
          <p class="text-sm">
            <i class="fa fa-arrow-up text-success" aria-hidden="true"></i>
            <span class="font-weight-bold">24%</span> this month
          </p>
        </div>
        <div class="card-body p-3">
          <div class="timeline timeline-one-side">
            <div class="timeline-block mb-3">
              <span class="timeline-step">
                <i class="material-symbols-rounded text-success text-gradient">notifications</i>
              </span>
              <div class="timeline-content">
                <h6 class="text-dark text-sm font-weight-bold mb-0">$2400, Design changes</h6>
                <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">22 DEC 7:20 PM</p>
              </div>
            </div>
            <div class="timeline-block mb-3">
              <span class="timeline-step">
                <i class="material-symbols-rounded text-danger text-gradient">code</i>
              </span>
              <div class="timeline-content">
                <h6 class="text-dark text-sm font-weight-bold mb-0">New order #1832412</h6>
                <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">21 DEC 11 PM</p>
              </div>
            </div>
            <div class="timeline-block mb-3">
              <span class="timeline-step">
                <i class="material-symbols-rounded text-info text-gradient">shopping_cart</i>
              </span>
              <div class="timeline-content">
                <h6 class="text-dark text-sm font-weight-bold mb-0">Server payments for April</h6>
                <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">21 DEC 9:34 PM</p>
              </div>
            </div>
            <div class="timeline-block mb-3">
              <span class="timeline-step">
                <i class="material-symbols-rounded text-warning text-gradient">credit_card</i>
              </span>
              <div class="timeline-content">
                <h6 class="text-dark text-sm font-weight-bold mb-0">New card added for order #4395133</h6>
                <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">20 DEC 2:20 AM</p>
              </div>
            </div>
            <div class="timeline-block mb-3">
              <span class="timeline-step">
                <i class="material-symbols-rounded text-primary text-gradient">key</i>
              </span>
              <div class="timeline-content">
                <h6 class="text-dark text-sm font-weight-bold mb-0">Unlock packages for development</h6>
                <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">18 DEC 4:54 AM</p>
              </div>
            </div>
            <div class="timeline-block">
              <span class="timeline-step">
                <i class="material-symbols-rounded text-dark text-gradient">payments</i>
              </span>
              <div class="timeline-content">
                <h6 class="text-dark text-sm font-weight-bold mb-0">New order #9583120</h6>
                <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">17 DEC</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <footer class="footer py-4  ">
    <div class="container-fluid">
      <div class="row align-items-center justify-content-lg-between">
        <div class="col-lg-6 mb-lg-0 mb-4">
          <div class="copyright text-center text-sm text-muted text-lg-start ">
            © <script>
              document.write(new Date().getFullYear())
            </script>,
            made with <i class="fa fa-heart"></i> by
            <a href="" class="font-weight-bold" target="_blank">Nguyen Tuan Anh</a>
            for a better web.
          </div>
        </div>
        <div class="col-lg-6">
          <ul class="nav nav-footer justify-content-center justify-content-lg-end">
            <li class="nav-item">
              <a href="" class="nav-link text-muted mb-0 h4 font-weight-bolder mb-4" target="_blank">Nguyen Tuan Anh</a>
            </li>
            <li class="nav-item">
              <a href="" class="nav-link text-muted mb-0 h4 font-weight-bolder mb-4" target="_blank">About Us</a>
            </li>
            <li class="nav-item">
              <a href" class="nav-link text-muted mb-0 h4 font-weight-bolder mb-4" target="_blank">Blog</a>
            </li>
            <li class="nav-item">
              <a href="" class="nav-link pe-0 text-muted mb-0 h4 font-weight-bolder mb-4" target="_blank">License</a>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </footer>
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  const chartData = <?php echo $chartData; ?>;

  if (Array.isArray(chartData)) {
    const labels = chartData.map(item => item.category_name); // Tên danh mục
    const data = chartData.map(item => item.product_count); // Số lượng sản phẩm

    document.addEventListener("DOMContentLoaded", function() {
      const chartContext = document.getElementById('categoryChart')?.getContext('2d');

      if (!chartContext) {
        console.error("Không tìm thấy phần tử canvas với id 'categoryChart'");
        return;
      }

      new Chart(chartContext, {
        type: 'bar',
        data: {
          labels: labels,
          datasets: [{
            label: 'So luong san pham',
            tension: 0.4,
            data: data,
            backgroundColor: "#43A047",
            borderColor: '#43A047',
            borderWidth: 0,
            borderRadius: 4,
            borderSkipped: false,
            pointRadius: 3,
            pointBackgroundColor: "#43A047",
            fill: true,

          }]
        },
        options: {
          responsive: true,
          scales: {
            y: {
              beginAtZero: true
            }
          }
        }
      });
    });
  } else {
    console.error("chartData không phải là mảng:", chartData);
  }
</script>