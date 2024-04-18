<div class="list-group settings-sidebar">
    <a href="{{Route('users.edit', Auth::user()->id)}}" class="list-group-item list-group-item-action {{ Request::is('users/*/edit') ? 'active' : '' }}">
      Profiel instellingen
    </a>
    <a href="{{Route('commercial.page-settings', Auth::user()->id)}}" class="list-group-item list-group-item-action {{ Request::is('commercial/page-settings/*') ? 'active' : '' }}">Eigen Landingspage</a>
</div>