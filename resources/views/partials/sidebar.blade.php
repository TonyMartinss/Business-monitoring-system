<div id="sidebar" class="active">
    <ul class="sidebar-menu">
        <li class="sidebar-item"><a href="{{ route('dashboard') }}" class="sidebar-link"><i class="bi bi-grid-fill"></i><span>Dashboard</span></a></li>
        <li class="sidebar-item has-sub">
            <a href="#" class="sidebar-link"><i class="bi bi-box-fill"></i><span>Items</span></a>
            <ul class="submenu">
                <li class="submenu-item"><a href="{{ route('items.index') }}">Inventory Overview</a></li>
                <li class="submenu-item"><a href="{{ route('items.create') }}">Add New Item</a></li>
                <li class="submenu-item"><a href="{{ route('items.categories') }}">Manage Categories</a></li>
                <li class="submenu-item"><a href="{{ route('items.suppliers') }}">Supplier Management</a></li>
                <li class="submenu-item"><a href="{{ route('items.alerts') }}">Stock Alerts</a></li>
                <li class="submenu-item"><a href="{{ route('items.analytics') }}">Item Analytics</a></li>
                <li class="submenu-item"><a href="{{ route('items.damage') }}">Damage/Expiry Report</a></li>
            </ul>
        </li>
        <li class="sidebar-item"><a href="{{ route('purchases.index') }}" class="sidebar-link"><i class="bi bi-cart-fill"></i><span>Purchases</span></a></li>
    </ul>
</div>