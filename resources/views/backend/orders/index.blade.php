@extends('backend.layout')
@section('backend_title', 'Order List')
@push('backend_css')
<style>
    * { box-sizing: border-box; margin: 0; padding: 0; }

    .order-container {
        padding: 28px;

        background: #f7f6f3;
        min-height: 100vh;
    }

    .order-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
    }

    .order-header h1 {
        font-size: 22px;
        font-weight: 700;
        color: #1a1a1a;
        letter-spacing: -0.3px;
    }

    .order-header span {
        font-size: 13px;
        color: #888;
    }

    .order-filters {
        display: flex;
        gap: 10px;
        margin-bottom: 20px;
        flex-wrap: wrap;
    }

    .filter-btn {
        padding: 6px 16px;
        border: 1.5px solid #ddd;
        background: #fff;
        border-radius: 20px;
        font-size: 13px;
        cursor: pointer;
        color: #555;
        transition: all 0.15s;
    }

    .filter-btn.active, .filter-btn:hover {
        background: #1a1a1a;
        border-color: #1a1a1a;
        color: #fff;
    }

    .order-table-wrapper {
        background: #fff;
        border-radius: 10px;
        border: 1px solid #e8e6e1;
        overflow: hidden;
    }

    .order-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 14px;
    }

    .order-table thead {
        background: #faf9f7;
        border-bottom: 1px solid #e8e6e1;
    }

    .order-table thead th {
        padding: 13px 18px;
        text-align: left;
        font-size: 11px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        color: #999;
    }

    .order-table tbody tr {
        border-bottom: 1px solid #f0ede8;
        transition: background 0.1s;
    }

    .order-table tbody tr:last-child { border-bottom: none; }
    .order-table tbody tr:hover { background: #faf9f7; }

    .order-table tbody td {
        padding: 14px 18px;
        color: #333;
        vertical-align: middle;
    }

    .order-id {
        font-weight: 600;
        color: #1a1a1a;
        font-size: 13px;
    }

    .customer-name {
        font-weight: 500;
        color: #222;
    }

    .customer-email {
        font-size: 12px;
        color: #999;
        margin-top: 2px;
    }

    .order-amount {
        font-weight: 600;
        color: #1a1a1a;
    }

    .status-badge {
        display: inline-block;
        padding: 3px 10px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
        letter-spacing: 0.3px;
    }

    .status-pending    { background: #fff8e1; color: #b8860b; }
    .status-processing { background: #e3f2fd; color: #1565c0; }
    .status-completed  { background: #e8f5e9; color: #2e7d32; }
    .status-cancelled  { background: #fce4ec; color: #c62828; }

    .action-btn {
        padding: 5px 12px;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 500;
        text-decoration: none;
        border: 1px solid #ddd;
        color: #444;
        background: #fff;
        cursor: pointer;
        transition: all 0.15s;
        margin-right: 4px;
        display: inline-block;
    }

    .action-btn:hover { background: #1a1a1a; color: #fff; border-color: #1a1a1a; }
    .action-btn.danger:hover { background: #c62828; border-color: #c62828; color: #fff; }

    .order-date { color: #888; font-size: 13px; }
</style>
@endpush

@section('backend_content')
<div class="order-container">

    <div class="order-header">
        <h1>Order List</h1>
        <span>Total: 6 orders</span>
    </div>

    <div class="order-filters">
        <button class="filter-btn active">All</button>
        <button class="filter-btn">Pending</button>
        <button class="filter-btn">Processing</button>
        <button class="filter-btn">Completed</button>
        <button class="filter-btn">Cancelled</button>
    </div>

    <div class="order-table-wrapper">
        <table class="order-table">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Customer</th>
                    <th>Date</th>
                    <th>Items</th>
                    <th>Amount</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>

                <tr>
                    <td class="order-id">#1001</td>
                    <td>
                        <div class="customer-name">John Smith</div>
                        <div class="customer-email">john@example.com</div>
                    </td>
                    <td class="order-date">01 Mar, 2026</td>
                    <td>3</td>
                    <td class="order-amount">$120.00</td>
                    <td><span class="status-badge status-completed">Completed</span></td>
                    <td>
                        <a href="#" class="action-btn">View</a>
                        <a href="#" class="action-btn">Edit</a>
                        <a href="#" class="action-btn danger">Del</a>
                    </td>
                </tr>

              



            </tbody>
        </table>
    </div>

</div>
@endsection

@push('backend_js')
<script>
    document.querySelectorAll('.filter-btn').forEach(btn => {
        btn.addEventListener('click', function () {
            document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
        });
    });
</script>
@endpush
