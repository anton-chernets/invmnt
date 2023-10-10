<li class="nav-item">
    <a href="{{ route('home') }}" class="nav-link">
        <i class="nav-icon fas fa-home"></i>
        <p>Home</p>
    </a>


    <a href="{{ route('user.rates') }}" class="nav-link {{ Request::is('user.rates') ? 'active' : '' }}">
        <i class="nav-icon fas fa-tachometer-alt"></i>
        <p>Currency Rates</p>
    </a>

    @can('horizon')
        <a href="{{ route('horizon.index') }}" class="nav-link {{ Request::is('horizon.index') ? 'active' : '' }}">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>Horizon dashboard</p>
        </a>
    @endif
</li>
