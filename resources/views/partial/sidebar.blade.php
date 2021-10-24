<aside class="main-sidebar">
  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">
    <!-- Sidebar user panel -->
    <div class="user-panel">
      <div class="pull-left image">
        <img src="{{asset('img/user_avatar.png')}}" class="img-circle" alt="User Image">
      </div>
      <div class="pull-left info">
        <p>{{$user->name}}</p>
        <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        <input type="hidden" name="auth_id" value="{{$user->id}}">
      </div>
    </div>
    @if ($user->type != 4)
    <span class="tw-hidden tw-bg-green-500 tw-bg-red-500"></span>
    <div class="tw-w-full tw-bg-gray-200 tw-text-white tw-font-bold tw-text-lg" id="server_tag">

    </div>
    @endif
    <!-- sidebar menu: : style can be found in sidebar.less -->
    <ul class="sidebar-menu" data-widget="tree">
      <li class="header">MENU</li>
      @if($user->type == 4)
      @include('partial.menu.customer', ['user' => $user])
      @elseif ($user->type == 2)
      @include('partial.menu.sales')
      @elseif ($user->type == 3)
      @include('partial.menu.ops')
      @elseif ($user->type == 1)
      @include('partial.menu.admin')
      @endif
      <li class="header">Misc.</li>
      <li>
        <a href="/change/password">
          <i class="fa fa-key"></i> <span>Change Password</span>
          {{-- <span class="pull-right-container">
            <small class="label pull-right bg-green">Hot</small>
          </span> --}}
        </a>
      </li>
      <li>
        {{-- <a href="#" onclick="event.preventDefault();document.getElementById('logout-form').submit();"> --}}
          <a href="#" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
            <i class="fa fa-power-off text-red"></i> <span>Logout</span>
            {{-- <span class="pull-right-container">
              <small class="label pull-right bg-green">Hot</small>
            </span> --}}
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            </form>
          </a>
      </li>
    </ul>
  </section>
  @push('script')


  @endpush

  <!-- /.sidebar -->
</aside>