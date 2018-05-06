<ul class="box-tab nav-tab" style="padding-top: 0px;padding-bottom: 0px;">
    <li class="@if(isset($menu) && $menu=='Web Dashboard') active @endif"><a href="{{url('dashboard')}}">dashboard</a></li>
    <li class="@if(isset($menu) && $menu=='Submitted App') active @endif"><a href="{{url('submitted_app')}}">My Submitted Apps</a></li>
    <li class="@if(isset($menu) && $menu=='New App') active @endif"><a href="{{url('step1')}}">Submit New App</a></li>
    <li><a href="http://www.thirdeyegen.com/developer">ThirdEye Developer Documentation</a></li>
    <li class="@if(isset($menu) && $menu=='user_reports') active @endif"><a href="{{route('users.reports')}}">Reports</a></li>
    {{--  <li class="@if(isset($menu) && $menu=='financial') active @endif"><a href="{{route('financial.index')}}">Financial Dashboard</a></li>  --}}
</ul>