@extends('frontend.dashboard.master')

@section('title', 'Events Corner')

@section('content')
 <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <style>
    body { margin:0; font-family: 'Inter', sans-serif; background:#f8f9fa; color:#333; }
    .container { display:flex; min-height:100vh; }


    .nav a:hover, .nav a.active { background:#e8f7f3; color:#00b894; font-weight:600; }
    .main { margin-left:240px; padding:30px; flex:1; }
    .header {
      display:flex; justify-content:space-between; align-items:center; margin-bottom:30px;
    }
    .card {
      background:#fff; border-radius:12px; padding:24px; box-shadow:0 2px 10px rgba(0,0,0,0.05);
      margin-bottom:24px;
    }
    h1 { font-size:28px; margin:0; color:#2d3436; }
    .chart-container {
      position:relative; height:450px; margin-top:20px;
    }
    .stats-grid {
      display:grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap:16px; margin:30px 0;
    }
    .stat-box {
      background:#fff; padding:20px; border-radius:10px; text-align:center;
      box-shadow:0 2px 8px rgba(0,0,0,0.06);
    }
    .stat-box h3 { margin:0; font-size:24px; color:#00b894; }
    .stat-box p { margin:8px 0 0; color:#636e72; font-size:14px; }
    .refresh-btn {
      background:#00b894; color:white; border:none; padding:10px 20px;
      border-radius:8px; cursor:pointer; font-weight:600;
    }
    .refresh-btn:hover { background:#009f7f; }
  </style>

  <br><br>
  <div class="main">
    <br>
      <div class="header">
        <h1>Traffic Sources</h1>
 <div>
          <button class="refresh-btn" onclick="location.reload()">Refresh Data</button>
        </div>
      </div>

      <!-- Summary Stats -->
      <div class="stats-grid">
        <div class="stat-box">
          <h3>342</h3>
          <p>Total Orders (Last 90 days)</p>
        </div>
        <div class="stat-box">
          <h3>145</h3>
          <p>WhatsApp</p>
        </div>
        <div class="stat-box">
          <h3>89</h3>
          <p>Facebook</p>
        </div>
        <div class="stat-box">
          <h3>67</h3>
          <p>Instagram</p>
        </div>
      </div>

      <!-- Chart Card -->
      <div class="card">
        <h2 style="margin-top:0; color:#2d3436;">Where Your Customers Came From</h2>
        <div class="chart-container">
          <canvas id="sourceChart"></canvas>
        </div>
      </div>

      <!-- Table (optional) -->
      <div class="card">
        <h2 style="margin-top:0;">Detailed Breakdown</h2>
        <table style="width:100%; border-collapse:collapse;">
          <thead>
            <tr style="background:#f1f2f6; text-align:left;">
              <th style="padding:12px;">Source</th>
              <th style="padding:12px;">Orders</th>
              <th style="padding:12px;">% of Total</th>
              <th style="padding:12px;">Revenue</th>
            </tr>
          </thead>
          <tbody>
            <tr><td style="padding:12px;">WhatsApp</td><td>145</td><td>42.4%</td><td>AUD $4,350</td></tr>
            <tr style="background:#f8f9fa;"><td style="padding:12px;">Facebook</td><td>89</td><td>26.0%</td><td>AUD $2,670</td></tr>
            <tr><td style="padding:12px;">Instagram</td><td>67</td><td>19.6%</td><td>AUD $2,010</td></tr>
            <tr style="background:#f8f9fa;"><td style="padding:12px;">Direct Link</td><td>23</td><td>6.7%</td><td>AUD $690</td></tr>
            <tr><td style="padding:12px;">Twitter / X</td><td>12</td><td>3.5%</td><td>AUD $360</td></tr>
            <tr style="background:#f8f9fa;"><td style="padding:12px;">Other</td><td>6</td><td>1.8%</td><td>AUD $180</td></tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <script>
    const ctx = document.getElementById('sourceChart').getContext('2d');
    const chart = new Chart(ctx, {
      type: 'doughnut',
      data: {
        labels: ['WhatsApp', 'Facebook', 'Instagram', 'Direct Link', 'Twitter/X', 'Other'],
        datasets: [{
          data: [145, 89, 67, 23, 12, 6],
          backgroundColor: [
            '#25D366',   // WhatsApp green
            '#1877F2',   // Facebook blue
            '#E4405F',   // Instagram pink
            '#00b894',   // Barren green
            '#1DA1F2',   // Twitter blue
            '#95A5A6'    // Gray
          ],
          borderWidth: 2,
          borderColor: '#fff'
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            position: 'right',
            labels: { font: { size: 14 } }
          },
          tooltip: {
            callbacks: {
              label: function(context) {
                let label = context.label || '';
                if (label) label += ': ';
                label += context.parsed + ' orders';
                const percent = ((context.parsed / 342) * 100).toFixed(1);
                return label + ` (${percent}%)`;
              }
            }
          }
        }
      }
    });
  </script>
</body>
@endsection
