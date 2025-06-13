<?php
include 'update_status_ajax.php';
include 'orders.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Spin Mode Laundry Hub</title>
  <link rel="stylesheet" href="mainStyle.css"/>
  <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined&display=swap" rel="stylesheet"/>
  <style>
    .content-section {
      display: none;
    }
    .content-section.active {
      display: block;
    }
  </style>
</head>
<body>
  <div class="container">
    <!------------ SIDEBAR ------------>
    <aside>
      <div class="top">
        <div class="logo">
          <img src="./images/logo-blue.png" alt="Spin Mode Logo" />
        </div>
        <div class="close" id="close-btn">
          <span class="material-symbols-outlined">close</span>
        </div>
      </div>

      <div class="sidebar">
        <a href="#" class="active" data-section="dashboard">
          <span class="material-symbols-outlined">dashboard</span>
          <h3>Dashboard</h3>
        </a>
        <a href="#" data-section="orders">
          <span class="material-symbols-outlined">receipt_long</span>
          <h3>Orders</h3>
        </a>
        <a href="#" data-section="history">
          <span class="material-symbols-outlined">history</span>
          <h3>History</h3>
        </a>

        <div class="sidebar-dropdown">
          <div id="analytics-toggle" class="nav-item">
            <span class="material-symbols-outlined">monitoring</span>
            <h3>Analytics</h3>
            <span class = "material-symbols-outlined dropdown-arrow">expand_more</span>
          </div>
          <div class="dropdown-menu" id="analytics-menu">
            <a href="#" class="dropdown-item" data-section="expenses">Monthly Expenses</a>
            <a href="#" class="dropdown-item" data-section="income">Income</a>
          </div>
        </div>

        <div class="sidebar-dropdown">
          <div id="status-toggle" class="nav-item">
            <span class="material-symbols-outlined">select_check_box</span>
            <h3>Status</h3>
            <span class = "material-symbols-outlined dropdown-arrow">expand_more</span>
          </div>
          <div class="dropdown-menu" id="status-menu">
            <a href="#" class="dropdown-item" data-section="unclaimed">Unclaimed</a>
            <a href="#" class="dropdown-item" data-section="unpaid">Unpaid</a>
            <a href="#" class="dropdown-item" data-section="customer-status">Status Summary</a>
          </div>
        </div>
                
        <a href="#" class="logout" id="logout">
            <span class="material-symbols-outlined">logout</span>
            <h3>Log out</h3>
        </a>
      </div>
    </aside>

    <!------------ MAIN ------------>
    <div class="main-content">
      <main>
        <!-- DASHBOARD -->
        <section id="dashboard" class="content-section active">
          <h1>Dashboard</h1>
          <div class="date">
          <label for="filterDate"></label>
            <input type="date" id="filterDate"/>
          </div>
          <div class="insights">
          <!--SALES-->
          <div class="sales">
            <span class="material-symbols-outlined">analytics</span>
            <div class="middle">
              <div class="left">
                <h3>TOTAL SALES</h3>
                <h1 id="salesAmount">Php 0.00</h1>
              </div>
              <div class="progress">
                <svg><circle cx="38" cy="38" r="36"></circle></svg>
                <div class="number"><p id="salesPercent">0%</p></div>
              </div>
            </div>
            <small class="text-muted" id="salesDateDisplay">Date: YYYY-MM-DD</small>

          </div>

          <!--UNPAID-->
            <div class="unpaid">
              <span class="material-symbols-outlined">cancel</span>
              <div class="middle">
                <div class="left">
                  <h3>NO. OF UNPAID</h3>
                </div>
                <div class="progress number-only">
                  <div class="number" id="unpaidCount"></div>
                </div>
              </div>
              <br><small class="text-muted" id="unpaidDate">Filtered by: YYYY-MM-DD</small>
              <div id="unpaidSection"></div>
            </div>

          <!--UNCLAIMED-->
            <div class="unclaimed">
              <span class="material-symbols-outlined">confirmation_number</span>
              <div class="middle">
                <div class="left">
                  <h3>NO. OF UNCLAIMED</h3>
                </div>
                <div class="progress number-only">
                  <div class="number" id="unclaimedCount"></div>
                </div>
              </div>
              <br><small class="text-muted" id="unclaimedDate">Filtered by: YYYY-MM-DD</small>
              <div id="unclaimedSection"></div>
            </div>
          </div>

          <!--MONTHLY ORDERS-->
          <div class="charts">
            <div class="charts-card">
              <h2 class="chart-title">Monthly Orders</h2>
              <div id="bar-chart"></div>
            </div>
          
          <!--MONTHLY SALES-->
            <div class="charts-card">
              <h2 class="chart-title">Monthly Sales</h2>
              <div id="area-chart"></div>
            </div>
          </div>
        </section>

        <!-- ORDERS -->
                <section id="orders" class="content-section">
          <h1>New Order</h1>
          <div class="order-wrapper">
            <div class="order-box">
              <form id="order-form" class="order-form" onsubmit="saveOrder(event)">
                <div class="form-row">
                  <label for="customer">Customer Name:</label>
                    <input type="text" id="customer" name="customer" pattern="^[a-zA-Z. ]+$" title="Only letters, spaces, and periods are allowed." oninput="this.value = this.value.replace(/[^a-zA-Z. ]/g, '')" required/>
                </div>

                <div class="form-row">
                  <label for="weight">Laundry Weight (kg):</label>
                  <input type="number" id="weight" name="weight" min="0" step="0.1" required />
                </div>

                <div class="form-row">
                <label>Contact Number:</label>
                <input type="text" id="cnum" name="cnum" pattern="^\d{11}$" maxlength="11" title="Contact number must be exactly 11 digits" oninput="this.value = this.value.replace(/\D/g, '').slice(0,11)"
                />
                </div>

                <div class="form-row">
                  <label for="timestamp">Time:</label>
                  <input type="timestamp" id="timestamp" name="timestamp" readonly/>
                </div>

                <div class="form-row">
                  <label for="service">Choose Service:</label>
                  <select id="service" name="service">
                    <option value="Deluxe Package">Deluxe Package</option>
                    <option value="Full Package">Full Package</option>
                    <option value="Wash">Wash</option>
                    <option value="Dry">Dry</option>
                    <option value="Wash Dry w/o Soap">Wash Dry w/o Soap</option>
                    <option value="Wash Dry w/ Soap">Wash Dry w/ Soap</option>
                    <option value="Wash Dry Fold">Wash, Dry, Fold</option>
                    <option value="Spin">Spin</option>
                  </select>
                </div>

                <fieldset class="form-row checkbox-group">
                  <legend>Add-ons:</legend>
                  <div class="checkbox-item">
                    <input type="checkbox" id="detergent-check" />
                    <label for="detergent-check">Detergent</label>
                    <label>Qty:</label>
                    <input type="number" id="detergent" min="1" disabled required/>
                  </div>

                  <div class="checkbox-item">
                    <input type="checkbox" id="fabcon-check" />
                    <label for="fabcon-check">Fabcon</label>
                    <label>Qty:</label>
                    <input type="number" id="fabcon" min="1" disabled required/>
                  </div>

                  <div class="checkbox-item">
                    <input type="checkbox" id="color-safe-check" />
                    <label for="color-safe-check">Color Safe</label>
                    <label>Qty:</label>
                    <input type="number" id="color-safe" min="1" disabled required/>
                  </div>

                  <div class="checkbox-item">
                    <input type="checkbox" id="extra-dry-check" />
                    <label for="extra-dry-check">Extra Dry</label>
                    <label>Qty:</label>
                    <input type="number" id="extra-dry" min="1" disabled required/>
                  </div>

                  <div class="checkbox-item">
                    <input type="checkbox" id="spin-check" />
                    <label for="spin-check">Spin</label>
                    <label>Qty:</label>
                    <input type="number" id="spin" min="1" disabled required/>
                  </div><br>

                  <label for="payment_method">Payment Method:</label>
                  <select name="payment_method" id="payment_method">
                    <option value="Cash">Cash</option>
                    <option value="GCash">GCash</option>
                  </select><br>

                  <label for="settlement">Settlement:</label>
                  <select name="settlement" id="settlement">
                    <option value="Unpaid">Unpaid</option>
                    <option value="Paid">Paid</option>
                  </select>
                </fieldset>

                <div class="form-buttons">
                  <button type="submit" class="btn save">SAVE ORDER</button>
                </div>
              </form>
            </div>


            <!---RIGHT RECEIPT-->
            <div class="order-box receipt-box hidden" id="receipt-box">
              <span class="material-symbols-outlined receipt-close" onclick="closeRec()">close</span>
              <h2>Receipt</h2>
              <button class="print-btn" onclick="printRec()">
              <span class="material-symbols-outlined">print</span>
            </button>
            <div id="receipt-cont"></div>
          </div>
        </section>
        
        
        <!-- HISTORY -->
        <section id="history" class="content-section">
          <h1>Order History</h1> 
          <div class="history-controls">

            <button id="reset-btn">All</button>
            <input type="text" id="history-search" name="search_query" placeholder="Search customer name..." pattern="^[a-zA-Z. ]+$" title="Only letters, spaces, and periods are allowed." oninput="this.value = this.value.replace(/[^a-zA-Z. ]/g, '')"/>
            <span class="material-symbols-outlined" id="search-btn">search</span>
          </div>
          
          <div class="table-wrapper">
            <table class="history-table">
              <thead>
                <tr>
                  <th></th>
                  <th style="text-align: center;">DATE</th>
                  <th style="text-align: center;">CUSTOMER ID</th>
                  <th style="text-align: center;">NAME</th>
                  <th style="text-align: center;">CONTACT NUMBER</th>
                  <th style="text-align: center;">WEIGHT</th>
                  <th style="text-align: center;">SERVICE</th>
                  <th style="text-align: center;">SERVICE BILL</th>
                  <th style="text-align: center;">ADD-ONS</th>
                  <th style="text-align: center;">ADD-ONS BILL</th>
                  <th style="text-align: center;">PAYMENT</th>
                  
                </tr>
              </thead>
              <tbody id="history-results">
              <?php
              viewAll($conn);
              ?>
              </tbody>
            </table>
            
        </section>

        <!-- ANALYTICS -->
        <section id="analytics" class="content-section">
          <h1>Analytics</h1>
        </section>
        <section id="expenses" class="content-section">
            <h1>Monthly Expenses</h1>
            <div class="expenses-date-controls">
              <label>Month:</label><br>
              <select id="expenses-month-select">
              </select>
                <label>Year:</label><br>
                <select id="expenses-year-select">
                </select>
            </div>

            <div class="expenses-data">
              <!-- expenses form -->
              <div id="expense-form-container">
              <form id="expenses-field">
                <div class="form-group">
                  <input type="text" name="expense-name" id="expense-name" placeholder="Enter expense name" required>
                </div>
                <div class="form-group">
                  <input type="number" name="expense-amount" id="expense-amount" placeholder="Enter amount" step="0.01" min="0" required>
                </div>
                <div class="form-group">
                  <button type="submit" class="submit-btn">Add</button>
                </div>
              </form>
              </div>

              <!-- expenses table -->
              <div class="expenses-wrapper">
                <table class="expenses-table">
                  <thead>
                    <tr>
                      <th>EXPENSE NAME</th>
                      <th>AMOUNT (₱)</th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody id="expenses-results">
                  </tbody>
                </table>
              </div>

              <!-- total display -->
              <div class="total-container">
                <span class="total-label">Total (₱):</span>
                <span class="total-amount">₱ 0.00</span>
              </div>
            </div>
          </section>

        <section id="income" class="content-section">
          <h1>Income</h1>
          <div class="income-wrapper">
            <div class="income-card-wrapper">   
            <div class="income-container">
            <div class="income-title">Overall Income</div>
            <div class="btn-wrapper">
                <form id="incomeForm" onsubmit="return false;">
                    <button type="submit" class="btn-income-overall" name="gross" onclick="getIncome('gross')">Gross Income</button>
                    <button type="submit" class="btn-income-overall" name="net" onclick="getIncome('net')">Net Income</button>
                </form>
            </div>
            <div class="total-income-container">
                <span class="total-income-label">Total Income (₱):</span>
                <span class="total-income-amount" id="incomeResult">...</span>
            </div>
          </div>

            <div class="income-container">
                  <div class="income-title">Income Summary</div>
                  <form id="income-summary-field" onsubmit="return false;">
                      <div class="date-fields">
                          <div class="summary-group">
                              <label for="from-date">From:</label>
                              <input type="date" name="startDate" id="from-date" required>
                          </div>
                          <div class="summary-group">
                              <label for="to-date">To:</label>
                              <input type="date" name="endDate" id="to-date" required>
                          </div>
                      </div>
                      
                      <div class="group-wrapper">
                          <div class="summary-group">
                              <select name="type" id="income-type" required>
                                  <option value="gross">Gross Income</option>
                                  <option value="net">Net Income</option>
                              </select>
                          </div>
                          
                          <div class="summary-group">
                              <button type="submit" class="enter-btn" onclick="getIncomeRange()">Enter</button>
                          </div>
                      </div>
                  </form>

                  <div class="total-income-container">
                      <span class="total-income-label">Total Income (₱):</span>
                      <span class="total-income-amount" id="incomeRange">...</span>
                  </div>
              </div>
            </div>

            <div class="income-card-wrapper">
            <div class="income-container">
              <div class="income-title">Annual Income</div>
              <form id="income-summary-field" onsubmit="return false;">
                  <div class="date-fields">
                      <div class="indiv-group">
                          <input type="number" name="year" id="year" placeholder="Year" min="1" required>
                      </div>
                  </div>
                  <div class="group-wrapper">
                      <div class="summary-group">
                      <select name="type" id="annual-income-type" required>
                          <option value="gross">Gross Income</option>
                          <option value="net">Net Income</option>
                      </select>

                      </div>
                      <div class="summary-group">
                          <button type="submit" class="enter-btn" onclick="getAnnualIncome()">Enter</button>
                      </div>
                  </div>
              </form>
              <div class="total-income-container">
                  <span class="total-income-label">Total Income (₱):</span>
                  <span class="total-income-amount" id="annualIncomeResult">...</span>
              </div>
          </div>

            <div class="income-container">
                <div class="income-title">Daily Income</div>
                <form id="income-summary-field" onsubmit="return false;">
                    <div class="date-fields">
                        <div class="summary-group">
                            <input type="date" name="date" id="date" required>
                        </div>
                    </div>
                    <div class="group-wrapper">
                        <div class="summary-group">
                            <select name="type" id="daily-income-type" required>
                                <option value="gross">Gross Income</option>
                                <option value="net">Net Income</option>
                            </select>
                        </div>
                        <div class="summary-group">
                            <button type="submit" class="enter-btn" onclick="getDailyIncome()">Enter</button>
                        </div>
                    </div>
                </form>
                <div class="total-income-container">
                    <span class="total-income-label">Total Income (₱):</span>
                    <span class="total-income-amount" id="dailyIncomeResult">...</span>
                </div>
            </div>
            </div>
          </div>
        </section>

        <!-- STATUS -->
        <section id="status" class="content-section">
          <h1>Status</h1>
          <p>Update and track real-time laundry statuses here.</p>
        </section>
        <section id="unclaimed" class="content-section">
          <h1>Unclaimed Orders</h1>
          <div class="table-wrapper">
            <table class="status-table">
              <thead>
                <tr>
                  <th style="text-align: center;">Select</th>
                  <th style="text-align: center;">Customer ID</th>
                  <th style="text-align: center;">Name</th>
                  <th style="text-align: center;">Claim Status</th>
                </tr>
              </thead>
              <tbody id="status-results">
              <?php
              showUnclaimedTable($conn);
              ?>
              </tbody>
            </table>
          </div>
        </section>

        <section id="unpaid" class="content-section">
          <h1>Unpaid Orders</h1>
          <div class="table-wrapper">
            <table class="status-table">
              <thead>
                <tr>
                  <th style="text-align: center;">Select</th>
                  <th style="text-align: center;">Customer ID</th>
                  <th style="text-align: center;">Name</th>
                  <th style="text-align: center;">Payment Status</th>
                </tr>
              </thead>
              <tbody id="unpaid-status-results">
              <?php
              showUnpaidTable($conn);
              ?>
              </tbody>
            </table>
          </div>
        </section>

        <section id="customer-status" class="content-section">
          <h1>All Customers</h1>
          <div class="table-wrapper">
            <table class="status-table">
              <thead>
                <tr>
                  <th style="text-align: center;">ID</th>
                  <th style="text-align: center;">Name</th>
                  <th style="text-align: center;">Status</th>
                  <th style="text-align: center;">Payment</th>
                </tr>
              </thead>
              <tbody id="customer-status-results">
              <?php
              showTransaction($conn);
              ?>
              </tbody>
            </table>
            <button id="refresh-button"></button>
          </div>
        </section>

      </main>
  
      <div class="right dashboard-only">
        <div class="top">
          <button id="menu-btn">
            <span class="material-symbols-outlined">menu</span>
          </button>
      
          <div class="top-controls">
          <div class="user-switcher-wrapper" id="userIcon">
              <span class="material-symbols-outlined user-icon">account_circle</span>
              <span class="user-label">USERS</span>
              <div class="user-menu hidden" id="userMenu">
                  <hr />
                  
                  <p class="user-option" id="addAccountMenu">Add Account</p>
                  <p class="user-option logout" id="logoutMenu">Log Out</p>
                  <p class="user-option" id="logHistory">
                    <label for="logsTable">User Activity Logs</label>
                  <table id="logsTable">
                    <thead>
                      <tr><th>Username</th><th>Action</th><th>Timestamp</th></tr>
                    </thead>
                    <tbody></tbody>
                  </table>
                  </p>

              </div>
          </div>

          <!-- Modal -->
          <div class="modal" id="addAccountModal">
              <div class="modal-content">
                  <span class="close-button" id="closeModal">&times;</span>
                  <h2>Add Account</h2>

                  <form id="addAccountForm" method="POST" action="">
                      <div class="input-field">
                    <input type="text" id="username" name="username" required placeholder=" " pattern="^[a-zA-Z. ]+$" title="Only letters, spaces, and periods are allowed." oninput="this.value = this.value.replace(/[^a-zA-Z. ]/g, '')" required>
                    <label for="empnum">Username</label>
                </div>
                
                <div class="input-field password-field">
                    <input type="password" id="password" name="password" required placeholder=" ">
                    <label for="password">Password</label>
                    <span class="toggle-password material-symbols-rounded">visibility</span>
                </div>

                <div class="input-field password-field">
                    <input type="password" id="confirmPassword" name="confirmPassword" required placeholder=" ">
                    <label for="password">Confirm Password</label>
                    <span class="toggle-password material-symbols-rounded">visibility</span>
                </div>
                      
                      <button type="submit" id="createAccountBtn">
                          👤 Create Account
                      </button>
                  </form>
              </div>
          </div>

      
            <div class="theme-toggler">
              <span class="material-symbols-outlined active">light_mode</span>
              <span class="material-symbols-outlined">dark_mode</span>
            </div>
          </div>
        </div>

        
        <div class="recent-orders">
        <div id="dashboardContent">
          </div>
      </div>
      </div>
      

  <!-- SCRIPTS -->
  <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script> <!--nadagdag-->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/apexcharts/4.5.0/apexcharts.min.js"></script>
  <script src="chartss.js" defer></script>
  <script>
    const sidebarLinks = document.querySelectorAll("aside .sidebar a[data-section]");
    const sections = document.querySelectorAll("main .content-section");
    const rightSection = document.querySelector(".right.dashboard-only");
    const themeToggler = document.querySelector(".theme-toggler");

    
    sidebarLinks.forEach(link => {
      link.addEventListener("click", function (e) {
        e.preventDefault();
        sidebarLinks.forEach(l => l.classList.remove("active"));
        this.classList.add("active");

        const sectionId = this.getAttribute("data-section");
        sections.forEach(section => {
          section.classList.remove("active");
          if (section.id == sectionId) {
            section.classList.add("active");
          }
        });

        if (sectionId == "dashboard") {
          rightSection.style.display = "flex";
        } else {
          rightSection.style.display = "none";
        }
      });
    });

    
    themeToggler.addEventListener('click', () => {
      document.body.classList.toggle('dark-theme-variables');
      themeToggler.querySelectorAll('span').forEach(icon => icon.classList.toggle('active'));
      
    });
  </script>


<script>
window.addEventListener('DOMContentLoaded', function () {
  fetch('orders.php', {
    method: 'POST',
    body: new FormData() 
  })
  .then(response => response.text())
  .then(data => {
    document.getElementById('results').innerHTML = data;
  });
});
</script>

<!-- PARA MARESET SA ALL YUNG HISTORY -->
<script>
document.getElementById('reset-btn').addEventListener('click', function () {
  const searchQuery = document.getElementById('history-search').value;

  const formData = new FormData();
  formData.append('search_query', searchQuery);

  fetch('all_handler.php', {
    method: 'POST',
    body: formData
  })
  .then(response => response.text())
  .then(data => {
    document.getElementById('history-results').innerHTML = data;
  });
});
</script>

<!-- PARA MASEARCH HISTORY BY NAME-->
<script>
document.getElementById('search-btn').addEventListener('click', function () {
  const searchQuery = document.getElementById('history-search').value;

  const formData = new FormData();
  formData.append('search_query', searchQuery);

  fetch('search_handler.php', {
    method: 'POST',
    body: formData
  })
  .then(response => response.text())
  .then(data => {
    document.getElementById('history-results').innerHTML = data;
  });
});
</script>

<!--Log out-->
<script>
        const logoutBtn = document.getElementById("logout");
        const logoutMenuBtn = document.getElementById("logoutMenu");

        logoutBtn.addEventListener('click', function (e) {
            e.preventDefault();
            logoutUser();
            
        });

        logoutMenuBtn.addEventListener('click', function (e) {
            e.preventDefault();
            logoutUser();
        });

function logoutUser() {
    fetch('logout.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        credentials: 'include' 
    })
    .then(res => res.json())
    .then(data => {
        if (data.status === 'success') {
            localStorage.removeItem('userData');
            sessionStorage.clear();
            
            window.location.href = 'login.html#login';
        } else {
            console.error('Logout failed:', data.message);
        }
    })
    .catch(err => console.error('Error during logout:', err));
}
</script>

<!-- YEAR OPTIONS EXPENSES NADAGDAG-->
<script>
  const yearExpensesSelect = document.getElementById('expenses-year-select');

  function generateExpensesYearOptions() {
    const currentYear = new Date().getFullYear();
    const startYear = 2020;

    yearExpensesSelect.innerHTML = '';

    for (let i = currentYear; i >= startYear; i--) {
      const option = document.createElement('option');
      option.value = i;
      option.textContent = i;
      yearExpensesSelect.appendChild(option);
    }

    yearExpensesSelect.value = currentYear;
  }

  window.addEventListener('load', generateExpensesYearOptions);
</script>

<!--Dashboard NADAGDAG-->
<script>
document.addEventListener("DOMContentLoaded", function () {
    const dateInput = document.getElementById("filterDate");

    
    const today = new Date().toISOString().split('T')[0];
    dateInput.value = today;
    fetchSales(today); 

    
    dateInput.addEventListener("change", function () {
        const selectedDate = this.value;
        fetchSales(selectedDate);
    });

    function fetchSales(date) {
        fetch("totalSales.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded",
            },
            body: new URLSearchParams({ date: date })
        })
        .then(response => response.json())
        .then(data => {
            document.getElementById("salesAmount").textContent = "Php " + data.sales;
            document.getElementById("salesPercent").textContent = data.percent + "%";

            document.getElementById("salesDateDisplay").textContent = "Date: " + date;
        })
        .catch(error => {
            console.error("Error fetching sales data:", error);
        });
    }
});

</script>
<!--RECENT ORDERS-->
<script>
document.querySelector('[data-section="dashboard"]').addEventListener('click', function (e) {
    e.preventDefault();
    
    fetch('dashboardRecent.php')
        .then(response => response.text())
        .then(data => {
            document.getElementById('dashboardContent').innerHTML = data;
        })
        .catch(error => {
            console.error('Error loading dashboard:', error);
        });
});
</script>
<script>
document.addEventListener('DOMContentLoaded', function () {
  const unclaimedCountEl = document.getElementById('unclaimedCount');
  const unclaimedDateEl = document.getElementById('unclaimedDate');
  const dateInput = document.getElementById('filterDate');

  function loadUnclaimedData(date = '') {
    const formData = new FormData();
    if (date) {
      formData.append('date', date);
    }

    fetch('dashboardUnclaimed.php', {
      method: 'POST',
      body: formData
    })
    .then(res => res.json())
    .then(data => {
      unclaimedCountEl.textContent = data.count;
      unclaimedDateEl.textContent = `Filtered by: ${data.date}`;
    })
    .catch(err => console.error('Error:', err));
  }

  loadUnclaimedData(); 

  dateInput.addEventListener('change', function () {
    loadUnclaimedData(this.value);
  });
});
</script>


<script>
document.addEventListener('DOMContentLoaded', function () {
  const countEl = document.getElementById('unpaidCount');
  const dateText = document.getElementById('unpaidDate');
  const dateInput = document.getElementById('filterDate');

  function loadUnpaidData(date = '') {
    const formData = new FormData();
    if (date) {
      formData.append('date', date);
    }

    fetch('dashboardUnpaid.php', {
      method: 'POST',
      body: formData
    })
    .then(res => res.json())
    .then(data => {
      countEl.textContent = data.count;
      dateText.textContent = `Filtered by: ${data.date}`;
    })
    .catch(err => console.error('Error:', err));
  }

  
  loadUnpaidData();

  
  dateInput.addEventListener('change', function () {
    loadUnpaidData(this.value);
  });
});
</script>

<!-- Expenses Part -->
<script>
  function fetchExpenses() {
    const month = document.getElementById('expenses-month-select').value;
    const year = document.getElementById('expenses-year-select').value;

    const formData = new URLSearchParams();
    formData.append('fetch', '1');
    formData.append('month', month);
    formData.append('year', year);

    fetch('expensesPart.php', {
      method: 'POST',
      headers: {'Content-Type': 'application/x-www-form-urlencoded'},
      body: formData.toString()
    })
    .then(response => response.json())
    .then(data => {
      const tbody = document.getElementById('expenses-results');
      const totalAmountSpan = document.querySelector('.total-amount');
      tbody.innerHTML = '';

      if (data.expenses.length > 0) {
        data.expenses.forEach(item => {
          const row = document.createElement('tr');
          row.innerHTML = `
            <td>${item.description}</td>
            <td>₱ ${parseFloat(item.amount).toFixed(2)}</td>
            <td>
              <button class="delete-btn" onclick="deleteExpense(${item.id})">
                <span class="material-symbols-outlined">delete</span>
              </button>
            </td>
          `;
          tbody.appendChild(row);
        });
      } else {
        const row = document.createElement('tr');
        row.innerHTML = `<td colspan="3" style="text-align:center;">No expenses found.</td>`;
        tbody.appendChild(row);
      }

      totalAmountSpan.textContent = `₱ ${parseFloat(data.total).toFixed(2)}`;
    })
    .catch(error => {
      console.error('Error fetching expenses:', error);
    });
  }

  function deleteExpense(id) {
    if (!confirm('Are you sure you want to delete this expense?')) return;

    fetch('expensesPart.php', {
      method: 'POST',
      headers: {'Content-Type': 'application/x-www-form-urlencoded'},
      body: `id=${id}`
    })
    .then(res => res.text())
    .then(response => {
      if (response.trim() == 'success') {
        fetchExpenses();
      } else {
        alert('Failed to delete expense.');
      }
    })
    .catch(err => console.error('Delete error:', err));
  }

  document.getElementById('expenses-field').addEventListener('submit', function(e) {
    e.preventDefault();

    const name = document.getElementById('expense-name').value.trim();
    const amount = parseFloat(document.getElementById('expense-amount').value);
    const month = document.getElementById('expenses-month-select').value;
    const year = document.getElementById('expenses-year-select').value;

    if (!name || isNaN(amount)) {
      alert('Please enter valid name and amount.');
      return;
    }

    const formData = new URLSearchParams();
    formData.append('add', '1');
    formData.append('description', name);
    formData.append('amount', amount);
    formData.append('month', month);
    formData.append('year', year);

    fetch('expensesPart.php', {
      method: 'POST',
      headers: {'Content-Type': 'application/x-www-form-urlencoded'},
      body: formData.toString()
    })
    .then(res => res.text())
    .then(response => {
      alert(response);
      document.getElementById('expenses-field').reset();
      fetchExpenses();
    })
    .catch(err => console.error('Insert error:', err));
  });

  document.addEventListener('DOMContentLoaded', () => {
    const monthSelect = document.getElementById('expenses-month-select');
    const yearSelect = document.getElementById('expenses-year-select');
    const now = new Date();

    const currentYear = now.getFullYear();
    for (let y = currentYear - 5; y <= currentYear + 5; y++) {
      const option = new Option(y, y);
      yearSelect.add(option);
    }

    monthSelect.value = now.getMonth() + 1;
    yearSelect.value = currentYear;

    fetchExpenses();
  });

  document.getElementById('expenses-month-select').addEventListener('change', fetchExpenses);
  document.getElementById('expenses-year-select').addEventListener('change', fetchExpenses);
</script>


<!-- MONTH OPTIONS -->
<script>
  const expensesMonthSelect = document.getElementById('expenses-month-select');

  function generateMonthOptions() {
    const months = [
      'All', 'January', 'February', 'March', 'April', 'May', 'June',
      'July', 'August', 'September', 'October', 'November', 'December'
    ];

    expensesMonthSelect.innerHTML = '';

    months.forEach((month, index) => {
      const option = document.createElement('option');
      option.value = index == 0 ? 0 : index;
      option.textContent = month;
      expensesMonthSelect.appendChild(option);
    });

    expensesMonthSelect.value = 0;
  }

  function handleMonthChange() {
    const month = document.getElementById('expenses-month-select').value;
    const formContainer = document.getElementById('expense-form-container');
    

    if (parseInt(month) == 0) {
      formContainer.style.visibility = 'hidden';
    } else {
      formContainer.style.visibility = 'visible';
    }

    fetchExpenses();
  }

  document.getElementById('expenses-month-select').addEventListener('change', handleMonthChange);


  window.addEventListener('load', () => {
  generateMonthOptions();
  document.getElementById('expense-form-container').style.visibility = 'hidden';
});
</script>

<!-- Income Part -->
<script>
document.addEventListener('DOMContentLoaded', function () {

    
    window.getIncome = function(type) {
        fetch('incomeAll.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: 'type=' + encodeURIComponent(type)
        })
        .then(response => response.ok ? response.text() : Promise.reject('Network error'))
        .then(data => {
            document.getElementById('incomeResult').innerHTML = data;
        })
        .catch(error => {
            document.getElementById('incomeResult').innerHTML = 'Error fetching income.';
            console.error('Error:', error);
        });
    };

   
    window.getIncomeRange = function() {
        const startDate = document.getElementById('from-date').value;
        const endDate = document.getElementById('to-date').value;
        const type = document.getElementById('income-type').value;

        if (!startDate || !endDate) {
            return;
        }

        const formData = new URLSearchParams({ startDate, endDate, type });

        fetch('incomerange.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: formData.toString()
        })
        .then(response => response.ok ? response.text() : Promise.reject('Network error'))
        .then(data => {
            document.getElementById('incomeRange').innerHTML = data;
        })
        .catch(error => {
            document.getElementById('incomeRange').innerHTML = 'Error fetching income.';
            console.error('Error:', error);
        });
    };

    
    window.getAnnualIncome = function() {
        const year = document.getElementById('year').value;
        const type = document.getElementById('annual-income-type').value;

        const formData = new URLSearchParams({ year, type });

        if (!year) {
            return;
        }

        fetch('incomeYear.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: formData.toString()
        })
        .then(response => response.ok ? response.text() : Promise.reject('Network error'))
        .then(data => {
            document.getElementById('annualIncomeResult').innerHTML = data;
        })
        .catch(error => {
            document.getElementById('annualIncomeResult').innerHTML = 'Error fetching income.';
            console.error('Error:', error);
        });
    };

    
    window.getDailyIncome = function() {
        const date = document.getElementById('date').value;
        const type = document.getElementById('daily-income-type').value;

        if (!date) {
            return;
        }

        const formData = new URLSearchParams({ date, type });

        fetch('incomeDay.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: formData.toString()
        })
        .then(response => response.ok ? response.text() : Promise.reject('Network error'))
        .then(data => {
            document.getElementById('dailyIncomeResult').innerHTML = data;
        })
        .catch(error => {
            document.getElementById('dailyIncomeResult').innerHTML = 'Error fetching income.';
            console.error('Error:', error);
        });
    };

});
</script> 

<!-- SCRIPT DROP DOWN -->
<script>
  const dropdownToggles = [
    { toggleId: "analytics-toggle", menuId: "analytics-menu" },
    { toggleId: "status-toggle", menuId: "status-menu" }
  ];

  dropdownToggles.forEach(({ toggleId }) => {
    const toggle = document.getElementById(toggleId);
    const container = toggle.closest('.sidebar-dropdown');

    toggle.addEventListener('click', () => {
     
      document.querySelectorAll('.sidebar-dropdown.open').forEach(openDropdown => {
        if (openDropdown !== container) {
          openDropdown.classList.remove('open');
        }
      });

      
      container.classList.toggle('open');
    });
  });
</script>

</script>

<script>
document.getElementById('timestamp').value = new Date().toLocaleString();

function toggleField(checkboxId, inputId) {
  document.getElementById(checkboxId).addEventListener('change', function () {
    document.getElementById(inputId).disabled = !this.checked;
  });

}
function printRec() {
  var content = document.getElementById('receipt-cont').innerHTML;
  var printWindow = window.open('', '', 'width=600,height=400');
  printWindow.document.write('<html><head><title>Print Receipt</title></head><body>');
  printWindow.document.write(content);
  printWindow.document.write('</body></html>');
  printWindow.document.close();
  printWindow.focus();
  printWindow.print();
  printWindow.close();
}

  function closeRec() {
    document.getElementById('receipt-box').classList.add('hidden');
  }

  document.addEventListener('DOMContentLoaded', function () {
    toggleField('detergent-check', 'detergent');
    toggleField('fabcon-check', 'fabcon');
    toggleField('color-safe-check', 'color-safe');
    toggleField('extra-dry-check', 'extra-dry');
    toggleField('spin-check', 'spin');

    document.getElementById('order-form').addEventListener('submit', saveOrder);
  });
  

function saveOrder(event) {
  event.preventDefault();

  const form = this;
  const formData = new FormData(form);

  const addons = [];
  const addonQuantities = {};

  const items = [
    { id: 'detergent', label: 'Detergent' },
    { id: 'fabcon', label: 'Fabcon' },
    { id: 'color-safe', label: 'ColorSafe' },
    { id: 'extra-dry', label: 'ExtraDry' },
    { id: 'spin', label: 'ExtraSpin' }
  ];

  items.forEach(item => {
    const checkbox = document.getElementById(`${item.id}-check`);
    const input = document.getElementById(item.id);
    if (checkbox && checkbox.checked) {
      addons.push(item.label);
      addonQuantities[item.label] = parseInt(input.value) || 1;
    }
  });

  addons.forEach(addon => {
    formData.append('addons[]', addon);
  });

  formData.append('quantities', JSON.stringify(addonQuantities));

  fetch('insertOrders.php', {
    method: 'POST',
    body: formData
  })
  .then(res => res.text())
  .then(data => {
    const receiptBox = document.getElementById('receipt-box');
    document.getElementById('receipt-cont').innerHTML = data;
    receiptBox.classList.remove('hidden');
    receiptBox.classList.add('visible');

    form.reset();
    document.getElementById('timestamp').value = new Date().toLocaleString();

    items.forEach(item => {
      document.getElementById(item.id).disabled = true;
    });

    fetch('refresh_handler.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
      body: new URLSearchParams({ action: 'transaction' })
    })
    .then(res => res.text())
    .then(data => {
      document.getElementById('customer-status-results').innerHTML = data;
    });

    fetch('refresh_handler.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
      body: new URLSearchParams({ action: 'history' })
    })
    .then(res => res.text())
    .then(data => {
      document.getElementById('history-results').innerHTML = data;
    });

    refreshUnpaidUnclaimed();
  })
  .catch(err => {
    alert("Error: " + err);
  });
}

function refreshUnpaidUnclaimed() {
  
  fetch('refresh_handler.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
    body: new URLSearchParams({ action: 'unpaid' })
  })
  .then(res => res.text())
  .then(data => {
    document.getElementById('unpaid-status-results').innerHTML = data;
    bindCheckboxHandlers(); 
  });

  
  fetch('refresh_handler.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
    body: new URLSearchParams({ action: 'unclaimed' })
  })
  .then(res => res.text())
  .then(data => {
    document.getElementById('status-results').innerHTML = data;
    bindCheckboxHandlers(); 
  });
}

function bindCheckboxHandlers() {
  document.querySelectorAll('.claim-checkbox').forEach(box => {
    box.addEventListener('change', function () {
      const id = this.dataset.id;
      const row = this.closest('tr');
      fetch('update_status_ajax.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: new URLSearchParams({ id, type: 'claim' })
      })
      .then(response => response.text())
      .then(data => {
        if (data.trim() === 'success') {
          row.remove();
          refreshTable();
          refreshUnpaidUnclaimed();
        }
      });
    });
  });

  document.querySelectorAll('.payment-checkbox').forEach(box => {
    box.addEventListener('change', function () {
      const id = this.dataset.id;
      const row = this.closest('tr');
      fetch('update_status_ajax.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: new URLSearchParams({ id, type: 'payment' })
      })
      .then(response => response.text())
      .then(data => {
        if (data.trim() === 'success') {
          row.remove();
          refreshTable();
          refreshUnpaidUnclaimed();
        }
      });
    });
  });
}

function refreshTable() {
  fetch('update_status_ajax.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
    body: new URLSearchParams({ action: 'refresh' })
  })
  .then(response => response.text())
  .then(data => {
    document.getElementById('customer-status-results').innerHTML = data;
  });
}

document.addEventListener('DOMContentLoaded', () => {
  document.getElementById('refresh-button').addEventListener('click', refreshTable);

  
  bindCheckboxHandlers();

  
  document.querySelectorAll('[data-section]').forEach(item => {
    item.addEventListener('click', (e) => {
      e.preventDefault();
      const section = e.currentTarget.getAttribute('data-section');

      document.querySelectorAll('.content-section').forEach(sec => {
        sec.classList.remove('active');
      });

      const sectionEl = document.getElementById(section);
      sectionEl.classList.add('active');

      const ordersData = [];
      if (ordersData[section]) {
        const tableBodyId =
          section == 'unclaimed' ? 'status-results' :
          section == 'unpaid' ? 'unpaid-status-results' :
          section == 'customer-status' ? 'customer-status-results' :
          null;

        if (tableBodyId) {
          const tableBody = document.getElementById(tableBodyId);
          tableBody.innerHTML = '';

          ordersData[section].forEach(order => {
            const row = document.createElement('tr');

            if (section == 'customer-status') {
              row.innerHTML = `
                <td>${order.id}</td>
                <td>${order.name}</td>
                <td>${order.status}</td>
                <td>${order.payment}</td>
              `;
            } else {
              row.innerHTML = `
                <td><input type="checkbox" class="select-checkbox"></td>
                <td>${order.id}</td>
                <td>${order.name}</td>
                <td>${order.status}</td>
              `;
            }

            tableBody.appendChild(row);
          });
        }
      }

      const rightSection = document.querySelector(".right.dashboard-only");
      rightSection.style.display = section == 'dashboard' ? 'flex' : 'none';
    });
  });

  const dashboardLink = document.querySelector('[data-section="dashboard"]');
  dashboardLink?.click();

  const userIcon = document.getElementById("userIcon");
  const userMenu = document.getElementById("userMenu");

  userIcon.addEventListener("click", () => {
    userMenu.classList.toggle("hidden");
  });

  document.addEventListener("click", (e) => {
    if (!userIcon.contains(e.target) && !userMenu.contains(e.target)) {
      userMenu.classList.add("hidden");
    }
  });
});
</script>

<!--ADD USER-->
<script>
document.addEventListener('DOMContentLoaded', function () {
    const addAccountMenu = document.getElementById('addAccountMenu'); 
    const addAccountModal = document.getElementById('addAccountModal'); 
    const closeModal = document.getElementById('closeModal'); 
    const addAccountForm = document.getElementById('addAccountForm'); 

    // Show modal
    addAccountMenu.addEventListener('click', function () {
        addAccountModal.style.display = 'block';
    });

    // Close modal
    closeModal.addEventListener('click', function () {
        addAccountModal.style.display = 'none';
        addAccountForm.reset();
    });

    // Close modal when clicking outside
    window.addEventListener('click', function (event) {
        if (event.target === addAccountModal) {
            addAccountModal.style.display = 'none';
            addAccountForm.reset();
        }
    });

    // Handle form submission
    addAccountForm.addEventListener('submit', function (event) {
        event.preventDefault();

        const username = document.getElementById('username').value.trim();
        const password = document.getElementById('password').value;
        const confirmPassword = document.getElementById('confirmPassword').value;

        if (password !== confirmPassword) {
            alert("Passwords do not match!");
            return;
        }

        fetch('add_account.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                username: username,
                password: password
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert("Account created successfully!");
                addAccountForm.reset(); 
                addAccountModal.style.display = 'none';
                loadAccounts(); // Refresh the account list
            } else {
                alert("Error: " + data.message);
            }
        })
        .catch(error => {
            console.error("AJAX Error:", error);
            alert("An unexpected error occurred. Please try again.");
        });
    });

    // Function to load accounts with delete buttons
    function loadAccounts() {
        fetch('accounts.php')
            .then(res => res.json())
            .then(accounts => {
                const userMenu = document.getElementById('userMenu');
                const dynamicItems = userMenu.querySelectorAll('.user-account-container');
                dynamicItems.forEach(item => item.remove());

                accounts.forEach(username => {
                    const container = document.createElement('div');
                    container.className = 'user-account-container';
                    
                    const accountText = document.createElement('p');
                    accountText.className = 'user-option user-account';
                    accountText.textContent = username;
                    
                    const deleteBtn = document.createElement('span');
                    deleteBtn.className = 'material-symbols-outlined delete-account-btn';
                    deleteBtn.textContent = 'delete';
                    deleteBtn.style.color = 'var(--color-danger)';
                    deleteBtn.style.cursor = 'pointer';
                    deleteBtn.style.marginLeft = '10px';
                    deleteBtn.addEventListener('click', (e) => {
                        e.stopPropagation();
                        if (confirm(`Are you sure you want to delete ${username}?`)) {
                            deleteAccount(username, container);
                        }
                    });
                    
                    container.appendChild(accountText);
                    container.appendChild(deleteBtn);
                    const addAccountMenu = document.getElementById('addAccountMenu');
                    userMenu.insertBefore(container, addAccountMenu);
                });
            })
            .catch(err => console.error('Error loading accounts:', err));
    }

    // Function to delete account
    function deleteAccount(username, element) {
    console.log("Attempting to delete:", username);
    
    fetch('delete_account.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ username: username })
    })
    .then(async response => {
        const text = await response.text();
        try {
            const data = JSON.parse(text);
            if (!response.ok) {
                throw new Error(data.message || 'Server error');
            }
            return data;
        } catch (e) {
            // If not JSON, show the raw response
            throw new Error(text || 'Invalid server response');
        }
    })
    .then(data => {
        if (data.success) {
            element.remove();
            alert(data.message || 'Account deleted successfully!');
        } else {
            throw new Error(data.message || 'Deletion failed');
        }
    })
    .catch(error => {
        console.error('Delete error:', error);
        alert('Error: ' + error.message);
    });
}

    // Load accounts when page loads
    loadAccounts();

    // Toggle password visibility
    document.querySelectorAll('.toggle-password').forEach(toggleBtn => {
        toggleBtn.addEventListener('click', function () {
            const inputField = this.closest('.password-field').querySelector('input');
            const type = inputField.getAttribute('type') === 'password' ? 'text' : 'password';
            inputField.setAttribute('type', type);
            this.textContent = type === 'password' ? 'visibility' : 'visibility_off';
        });
    });
});

// Keep your existing logs code
window.addEventListener('DOMContentLoaded', () => {
  fetch('view_logs.php')
    .then(response => response.json())
    .then(data => {
      const tbody = document.querySelector('#logsTable tbody');
      tbody.innerHTML = ''; 

      data.forEach(log => {
        const tr = document.createElement('tr');
        tr.innerHTML = `
          <td>${log.username}</td>
          <td>${log.action}</td>
          <td>${log.timestamp}</td>
        `;
        tbody.appendChild(tr);
      });

      document.getElementById('logsTable').style.display = 'table'; 
    })
    .catch(error => {
      console.error('Error fetching logs:', error);
      alert('Failed to load user logs.');
    });
});
</script>






