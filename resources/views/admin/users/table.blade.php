<table class="table table-striped table-hover usersTable">
  <thead>
    <tr class="table-dark">
      <th scope="col">#</th>
      <th scope="col">Profile Picture</th>
      <th scope="col">Name</th>
      <th scope="col" class="d-none d-lg-table-cell">Email</th>
      <th scope="col">Role</th>
      <th scope="col">Actions</th>
    </tr>
  </thead>
  <tbody>
    @if ($users->count())  
      @foreach ($users as $user)
        <tr>
          <th scope="row">{{ ($users->currentPage() - 1) * $users->perPage() + $loop->iteration }}</th>
          <td><img src="{{ $user->image != null ? asset('storage/' . $user->image) : asset('images/default.png') }}" alt="{{ $user->image }}" class="img-fluid" width="50px"></td>
          <td>{{ $user->name }}</td>
          <td class="d-none d-lg-table-cell">{{ $user->email }}</td>
          <td>{{ $user->role }}</td>
          <td>
            <div class="dropdown">
              <button class="drop-border" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="bi bi-three-dots-vertical"></i>
              </button>
              <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">             
                <li><a class="dropdown-item" href="{{ route('admin.users.show', $user['id']) }}">
                  <i class="bi bi-clock-history"></i>
                  Order History</a></li>
                <li>
                  <a class="dropdown-item edit-user-link" href="#" data-id="{{ $user->id }}">
                    <i class="bi bi-pencil"></i>  
                    Edit
                  </a>
                </li>
                <li>
                  <button type="button" class="dropdown-item text-danger delete-action" 
                  data-id="{{ $user->id }}" 
                  data-type="users">
                    <i class="bi bi-trash3"></i>
                    Delete
                  </button>
                </li>
              </ul>
            </div>
          </td>
        </tr>
      @endforeach
    @else
      <tr>
        <td colspan="6" class="text-center py-2">No Users Found</td>
      </tr>
    @endif
  </tbody>
</table>

<!-- Pagination Links -->
<div class="d-flex justify-content-center">
  <div id="paginationLinks">
    {{ $users->links('vendor.pagination.bootstrap-4') }}
  </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deleteLabel">Confirm Deletion</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Are you sure you want to delete this user?
      </div>
      <div class="modal-footer">
        <form id="deleteForm" method="POST">
          @csrf
          @method('DELETE')
          <button type="submit" class="btn btn-danger">Delete</button>
        </form>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>

<div id="ajaxEditModalContainer"></div>
@include('admin.users.edit')
