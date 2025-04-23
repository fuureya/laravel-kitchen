<div class="row">
    <div class="col-xl-12 col-lg-12">
        <div class="card shadow mb-4">
            @if (session()->has('message'))
                <div class="alert alert-success">{{ session('message') }}</div>
            @endif
            <div class="card-body py-3">
                <div class="my-5">
                    <h4 class="font-weight-bold text-primary">Supplier Management</h4>
                    @if (in_array('view-suppliers', auth()->user()->permissions))
                        <button type="button" class="btn btn-primary mt-3" wire:click="openModal" data-toggle="modal"
                            data-target="#modalAdd">
                            <i class="fas fa-plus"></i> Add Supplier
                        </button>
                    @endif
                </div>
                <div class="table-responsive" style="overflow-x: auto">
                    <table class="table table-bordered " style="width:100%; white-space: nowrap;">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>PIC</th>
                                <th>Phone</th>
                                <th>Email</th>
                                <th>AP Limit</th>
                                <th>Insert By</th>
                                <th>Insert Date</th>
                                <th>Update By</th>
                                <th>Update Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($suppliers as $supplier)
                                <tr>
                                    <td>{{ $supplier->id }}</td>
                                    <td>{{ $supplier->name }}</td>
                                    <td>{{ $supplier->pic }}</td>
                                    <td>{{ $supplier->phone }}</td>
                                    <td>{{ $supplier->email }}</td>
                                    <td>{{ number_format($supplier->ap_limit, 2) }}</td>
                                    <td>{{ $supplier->insert_by }}</td>
                                    <td>{{ $supplier->insert_date->format('Y-m-d H:i') }}</td>
                                    <td>{{ $supplier->last_update_by }}</td>
                                    <td>{{ $supplier->last_update_time }}</td>
                                    <td>
                                        @if (in_array('update-suppliers', auth()->user()->permissions))
                                            <button wire:click="edit({{ $supplier->id }})" class="btn"
                                                data-toggle="modal" data-target="#modalEdit">
                                                <i class="fas fa-edit text-success"></i>
                                            </button>
                                        @endif
                                        @if (in_array('hapus-suppliers', auth()->user()->permissions))
                                            <button wire:click="delete({{ $supplier->id }})" class="btn"
                                                wire:confirm="Are you sure you want to delete this supplier?">
                                                <i class="fas fa-trash text-danger"></i>
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="mt-4">
                    {{ $suppliers->links() }}
                </div>
            </div>
        </div>
    </div>

    <!-- Add Modal -->
    <div class="modal fade" id="modalAdd" data-backdrop="static" data-keyboard="false" tabindex="-1"
        aria-labelledby="modalAddLabel" aria-hidden="true" wire:ignore>

        <div class="modal-dialog modal-lg">
            @if ($errors->any())
                @foreach ($errors->all() as $error)
                    <div class="alert alert-danger" role="alert">
                        {{ $error }}
                    </div>
                @endforeach
            @endif
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalAddLabel">Add New Supplier</h5>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                        wire:click="closeModal">
                        <span aria-hidden="true">&times;</span>
                    </button>

                </div>
                <div class="modal-body">
                    <form>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">Supplier Name</label>
                                    <input type="text" class="form-control" id="name"
                                        placeholder="Enter supplier name" wire:model="name">
                                </div>
                                <div class="form-group">
                                    <label for="pic">Person in Charge</label>
                                    <input type="text" class="form-control" id="pic"
                                        placeholder="Enter PIC name" wire:model="pic">
                                </div>
                                <div class="form-group">
                                    <label for="phone">Phone Number</label>
                                    <input type="text" class="form-control" id="phone"
                                        placeholder="Enter phone number" wire:model="phone">
                                </div>
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control" id="email" placeholder="Enter email"
                                        wire:model="email">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="street">Street Address</label>
                                    <input type="text" class="form-control" id="street"
                                        placeholder="Enter street address" wire:model="street">
                                </div>
                                <div class="form-group">
                                    <label for="city">City</label>
                                    <input type="text" class="form-control" id="city" placeholder="Enter city"
                                        wire:model="city">
                                </div>
                                <div class="form-group">
                                    <label for="country">Country</label>
                                    <input type="text" class="form-control" id="country"
                                        placeholder="Enter country" wire:model="country">
                                </div>
                                <div class="form-group">
                                    <label for="ap_limit">AP Limit</label>
                                    <input type="number" step="0.01" class="form-control" id="ap_limit"
                                        placeholder="Enter AP limit" wire:model="ap_limit">
                                </div>
                            </div>
                        </div>

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"
                        wire:click="closeModal">Close</button>
                    <button type="button" class="btn btn-primary" wire:click="store">Save
                        Supplier</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="modalEdit" data-backdrop="static" data-keyboard="false" tabindex="-1"
        aria-labelledby="modalEditLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEditLabel">Edit Supplier</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                        wire:click="closeModal">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">Supplier Name</label>
                                    <input type="text" class="form-control" id="name" wire:model="name">
                                </div>
                                <div class="form-group">
                                    <label for="pic">Person in Charge</label>
                                    <input type="text" class="form-control" id="pic" wire:model="pic">
                                </div>
                                <div class="form-group">
                                    <label for="phone">Phone Number</label>
                                    <input type="text" class="form-control" id="phone" wire:model="phone">
                                </div>
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control" id="email" wire:model="email">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="street">Street Address</label>
                                    <input type="text" class="form-control" id="street" wire:model="street">
                                </div>
                                <div class="form-group">
                                    <label for="city">City</label>
                                    <input type="text" class="form-control" id="city" wire:model="city">
                                </div>
                                <div class="form-group">
                                    <label for="country">Country</label>
                                    <input type="text" class="form-control" id="country" wire:model="country">
                                </div>
                                <div class="form-group">
                                    <label for="ap_limit">AP Limit</label>
                                    <input type="number" step="0.01" class="form-control" id="ap_limit"
                                        wire:model="ap_limit">
                                </div>
                            </div>
                        </div>

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"
                        wire:click="closeModal">Close</button>
                    <button type="button" class="btn btn-primary" wire:click="update">Update Supplier</button>
                </div>
            </div>
        </div>
    </div>
</div>

@script
    <script>
        document.addEventListener('livewire:initialized', () => {
            Livewire.on('closeModal', () => {
                $('#modalAdd').modal('hide');
                $('#modalEdit').modal('hide');
            });

            Livewire.on('formSubmitted', () => {
                $('#modalAdd').modal('hide');
            });

            Livewire.on('editSubmitted', () => {
                $('#modalEdit').modal('hide');
            });
        });
    </script>
@endscript
