# master.blade.php
<?php
@php
    function conditions($permission) {
        $roles = Spatie\Permission\Models\Role::pluck('name')->toArray();
        if(auth()->user()->hasAnyRole($roles) && auth()->user()->hasAnyPermission(['all-menu', $permission])){
            return true;
        };   
        return false;
    }
@endphp

@if(conditions('job'))
  <li class="nav-item">
      <a href="{{ url('admin/jobs') }}" class="nav-link">
          <i class="nav-icon fa fa-chain"></i> Job
      </a>
  </li>
  @endif

  @if(conditions('job-cancel'))
  <li class="nav-item">
      <a href="{{ url('admin/job-cancels') }}" class="nav-link">
          <i class="nav-icon fa fa-bell-o"></i> Job Cancel
          <span class="badge badge-danger">{{ $pending_jobs_count }}</span>
      </a>
  </li>
  @endif

  @if(conditions('assign-technician'))
  <li class="nav-item">
      <a href="{{ url('admin/assign_technicians') }}" class="nav-link">
          <i class="nav-icon fa fa-wrench"></i> Assign Technician
      </a>
  </li>
@endif

# description
 /*
- if we use laravel spatie permission, we can make a condition for the permission as above to be able to hide and show the menu depending on the user's permissions
- hide and show menu using this condition cannot solve the real problem that means the normal authenticated user can be still able to access some actions via url paths, to protect this issue, we have to use middleware like the following ...
*/

// this sample can be found on the official docs
class JobController extends Controller {
    public function __construct()
    {
        // this mean that only a user with "all-menu" and "job" can access all actions that control by the JobController
        $this->middleware(['permission:all-menu|job']);
    }
}
