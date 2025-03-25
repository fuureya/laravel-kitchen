<div class="row">
    <div class="col-xl-12 col-lg-12">
        <div class="card shadow mb-4">
            @if (session()->has('message'))
                <div class="alert alert-success">{{ session('message') }}</div>
            @endif
            <div class="card-body py-3">
                <div class="my-5">
                    <h4 class="font-weight-bold text-primary">Unit Of Measurement</h4>
                    <button type="button" class="btn btn-primary mt-3" data-toggle="modal" data-target="#modalAdd">
                        <i class="fas fa-plus"></i>
                    </button>
                </div>
                <div class="table-responsive">
                    <table id="dataTable" class="table table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Insert By</th>
                                <th>Insert Time</th>
                                <th>Last Update By</th>
                                <th>Last Update Time</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($uoms as $uom)
                                <tr>
                                    <td>{{ $uom->id }}</td>
                                    <td>{{ $uom->name }}</td>
                                    <td>{{ $uom->insert_by }}</td>
                                    <td>{{ $uom->insert_time }}</td>
                                    <td>{{ $uom->last_update_by }}</td>
                                    <td>{{ $uom->last_update_time }}</td>
                                    <td>
                                        <button wire:click="edit({{ $uom->id }})"
                                            class="btn btn-warning">Edit</button>
                                        <button wire:click="delete({{ $uom->id }})"
                                            class="btn btn-danger">Delete</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="modalAdd" data-backdrop="static" data-keyboard="false" tabindex="-1"
        aria-labelledby="modalAddLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalAddLabel">Add New Record</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @if ($errors->any())
                    @foreach ($errors->all() as $error)
                        <div class="alert alert-danger" role="alert">
                            {{ $error }}
                        </div>
                    @endforeach
                @endif
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="name" placeholder="Enter Name"
                                wire:model='name'>
                        </div>
                        <div class="form-group">
                            <label for="insert_by">Insert By</label>
                            <input type="text" class="form-control" id="insert_by" placeholder="Inserted By"
                                wire:model='insert_by'>
                        </div>
                        <div class="form-group">
                            <label for="insert_time">Insert Time</label>
                            <input type="datetime-local" class="form-control" id="insert_time" wire:model='insert_time'>
                        </div>
                        <div class="form-group">
                            <label for="last_update_by">Last Update By</label>
                            <input type="text" class="form-control" id="last_update_by" placeholder="Last Updated By"
                                wire:model='last_update_by'>
                        </div>
                        <div class="form-group">
                            <label for="last_update_time">Last Update Time</label>
                            <input type="datetime-local" class="form-control" id="last_update_time"
                                wire:model='last_update_time'>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" wire:click='store'>Save
                        Changes</button>
                </div>
            </div>
        </div>
    </div>
</div>

@script('scripts')
    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable({
                responsive: true,

                search: {
                    caseInsensitive: true,
                    regex: false,
                    smart: true
                },
                dom: '<"top"<"float-left"l><"float-right"f>>rt<"bottom"ip>',
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Search records..."
                }
            });
        });

        Livewire.on('formSubmitted', () => {
            $('#modalAdd').modal('hide');
        });
        Livewire.on('editSubmitted', () => {
            $('#updateModal').modal('hide');
        });
    </script>
@endscript
