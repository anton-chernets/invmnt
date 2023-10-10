<li class="nav-item">
    <a href="{{ route('home') }}" class="nav-link {{ Request::is('home') ? 'active' : '' }}">
        <i class="nav-icon fas fa-home"></i>
        <p>Home</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('user.rates') }}" class="nav-link {{ Request::is('user/rates') ? 'active' : '' }}">
        <i class="nav-icon fas fa-tachometer-alt"></i>
        <p>Currency Rates</p>
    </a>
</li>

@can('horizon')
    <li class="nav-item">
        <a href="{{ route('horizon.index') }}" class="nav-link">
            <p>Horizon dashboard</p>
        </a>
    </li>
@endif
