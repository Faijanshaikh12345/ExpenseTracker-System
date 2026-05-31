{{-- resources/views/dashboard/index.blade.php --}}

@extends('layouts.app')

@section('title', 'Dashboard')
@section('page_title', 'Dashboard')

@section('breadcrumb')
  <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
  <li class="breadcrumb-item active">Dashboard</li>
@endsection

@section('content')

  <!-- Small boxes (Stat box) -->
  <div class="row">

    <div class="col-lg-3 col-6">
      <div class="small-box bg-success">
        <div class="inner">
          <h3>{{ $totalIncome }}</h3>
          <p>Total Income</p>
        </div>
        <div class="icon"><i class="ion ion-bag"></i></div>
        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
      </div>
    </div>

    <div class="col-lg-3 col-6">
      <div class="small-box bg-info">
        <div class="inner">
          <h3>{{ $totalExpense }}</h3>
          <p>Total Expenses</p>
        </div>
        <div class="icon"><i class="ion ion-stats-bars"></i></div>
        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
      </div>
    </div>

    <div class="col-lg-3 col-6">
      <div class="small-box bg-warning">
        <div class="inner">
          <h3>{{ $balance }}</h3>
          <p>Your Balance</p>
        </div>
        <div class="icon"><i class="ion ion-person-add"></i></div>
        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
      </div>
    </div>

    <div class="col-lg-3 col-6">
      <div class="small-box bg-danger">
        <div class="inner">
          <h3>{{ $categoriesCount }}</h3>
          <p>All Categories</p>
        </div>
        <div class="icon"><i class="ion ion-pie-graph"></i></div>
        <a href="{{ route('categories.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
      </div>
    </div>

  </div>
  <!-- /.row (stat boxes) -->


  <!-- Charts Row -->
  <div class="row">

    <!-- Line Chart: Income vs Expense -->
    <div class="col-lg-8 col-12">
      <div class="card card-primary card-outline">
        <div class="card-header">
          <h3 class="card-title">
            <i class="fas fa-chart-line mr-1"></i> Income vs Expense (Monthly)
          </h3>
        </div>
        <div class="card-body">
          <canvas id="incomeExpenseChart" height="120"></canvas>
        </div>
      </div>
    </div>

    <!-- Doughnut Chart: Balance Breakdown -->
    <div class="col-lg-4 col-12">
      <div class="card card-success card-outline">
        <div class="card-header">
          <h3 class="card-title">
            <i class="fas fa-chart-pie mr-1"></i> Balance Breakdown
          </h3>
        </div>
        <div class="card-body d-flex flex-column align-items-center">
          <canvas id="balanceChart" height="200"></canvas>
          <div class="mt-3 d-flex justify-content-around w-100">
            <span><i class="fas fa-circle text-success mr-1"></i> Income</span>
            <span><i class="fas fa-circle text-danger mr-1"></i> Expense</span>
            <span><i class="fas fa-circle text-warning mr-1"></i> Balance</span>
          </div>
        </div>
      </div>
    </div>

  </div>
  <!-- /.charts row -->

@endsection

@push('scripts')
  {{-- Chart.js CDN --}}
  <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

  <script>
    // ── Data passed from controller ──────────────────────────────────────────
    const monthlyLabels  = @json($monthlyLabels);   // e.g. ['Jan','Feb',...]
    const monthlyIncome  = @json($monthlyIncome);   // e.g. [500, 800, ...]
    const monthlyExpense = @json($monthlyExpense);  // e.g. [300, 450, ...]
    const totalIncome    = {{ $totalIncome }};
    const totalExpense   = {{ $totalExpense }};
    const balance        = {{ $balance }};

    // ── 1. Line Chart — Income vs Expense ────────────────────────────────────
    const lineCtx = document.getElementById('incomeExpenseChart').getContext('2d');
    new Chart(lineCtx, {
      type: 'line',
      data: {
        labels: monthlyLabels,
        datasets: [
          {
            label: 'Income',
            data: monthlyIncome,
            borderColor: '#28a745',
            backgroundColor: 'rgba(40,167,69,0.1)',
            borderWidth: 2,
            pointBackgroundColor: '#28a745',
            fill: true,
            tension: 0.4,
          },
          {
            label: 'Expense',
            data: monthlyExpense,
            borderColor: '#dc3545',
            backgroundColor: 'rgba(220,53,69,0.1)',
            borderWidth: 2,
            pointBackgroundColor: '#dc3545',
            fill: true,
            tension: 0.4,
          }
        ]
      },
      options: {
        responsive: true,
        plugins: {
          legend: { position: 'top' },
          tooltip: { mode: 'index', intersect: false }
        },
        scales: {
          y: {
            beginAtZero: true,
            ticks: {
              callback: value => '₹' + value.toLocaleString()
            }
          }
        }
      }
    });

    // ── 2. Doughnut Chart — Balance Breakdown ────────────────────────────────
    const donutCtx = document.getElementById('balanceChart').getContext('2d');
    new Chart(donutCtx, {
      type: 'doughnut',
      data: {
        labels: ['Income', 'Expense', 'Balance'],
        datasets: [{
          data: [totalIncome, totalExpense, balance > 0 ? balance : 0],
          backgroundColor: ['#28a745', '#dc3545', '#ffc107'],
          borderColor: ['#fff', '#fff', '#fff'],
          borderWidth: 3,
        }]
      },
      options: {
        responsive: true,
        cutout: '65%',
        plugins: {
          legend: { display: false },
          tooltip: {
            callbacks: {
              label: ctx => ' ₹' + ctx.parsed.toLocaleString()
            }
          }
        }
      }
    });
  </script>
@endpush