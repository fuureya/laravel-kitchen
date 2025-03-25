<div class="row">
    <div class="col-xl-12 col-lg-12">
        <div class="card shadow mb-4">
            @if (session()->has('message'))
                <div class="alert alert-success">{{ session('message') }}</div>
            @endif
            <div class="card-body py-3">
                <div class="my-5">
                    <h4 class="font-weight-bold text-primary">Inventory Management</h4>
                    <button type="button" class="btn btn-primary mt-3" wire:click="openModal" data-toggle="modal"
                        data-target="#modalAdd">
                        <i class="fas fa-plus"></i> Add Inventory
                    </button>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Category</th>
                                <th>UOM</th>
                                <th>Price</th>
                                <th>Min Stock</th>
                                <th>Status</th>
                                <th>Insert By</th>
                                <th>Insert Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($inventories as $inventory)
                                <tr>
                                    <td>{{ $inventory->id }}</td>
                                    <td>{{ $inventory->name }}</td>
                                    <td>{{ $inventory->category->name }}</td>
                                    <td>{{ $inventory->uom->name }}</td>
                                    <td>{{ number_format($inventory->price, 2) }}</td>
                                    <td>{{ $inventory->stock_minimum }}</td>
                                    <td>
                                        <span
                                            class="badge badge-{{ $inventory->status == 'active' ? 'success' : 'danger' }}">
                                            {{ ucfirst($inventory->status) }}
                                        </span>
                                    </td>
                                    <td>{{ $inventory->insert_by }}</td>
                                    <td>{{ $inventory->insert_date->format('Y-m-d H:i') }}</td>
                                    <td>
                                        <button wire:click="edit({{ $inventory->id }})" class="btn"
                                            data-toggle="modal" data-target="#modalEdit">
                                            <i class="fas fa-edit text-success"></i>
                                        </button>
                                        <button wire:click="delete({{ $inventory->id }})" class="btn"
                                            wire:confirm="Are you sure you want to delete this item?">
                                            <i class="fas fa-trash text-danger"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="mt-4">
                    {{ $inventories->links() }}
                </div>
            </div>
        </div>
    </div>

    <!-- Add Modal -->
    <div class="modal fade" id="modalAdd" data-backdrop="static" data-keyboard="false" tabindex="-1"
        aria-labelledby="modalAddLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalAddLabel">Add New Inventory Item</h5>
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
                                    <label for="name">Item Name</label>
                                    <input type="text" class="form-control" id="name"
                                        placeholder="Enter item name" wire:model="name">
                                </div>
                                <div class="form-group">
                                    <label for="category_id">Category</label>
                                    <select class="form-control" id="category_id" wire:model="category_id">
                                        <option value="">Select Category</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="uom_code">Unit of Measurement</label>
                                    <select class="form-control" id="uom_code" wire:model="uom_code">
                                        <option value="">Select UOM</option>
                                        @foreach ($uoms as $uom)
                                            <option value="{{ $uom->id }}">{{ $uom->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="price">Price</label>
                                    <input type="number" step="0.01" class="form-control" id="price"
                                        placeholder="Enter price" wire:model="price">
                                </div>
                                <div class="form-group">
                                    <label for="stock_minimum">Minimum Stock</label>
                                    <input type="number" class="form-control" id="stock_minimum"
                                        placeholder="Enter minimum stock" wire:model="stock_minimum">
                                </div>
                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <select class="form-control" id="status" wire:model="status">
                                        <option value="active">Active</option>
                                        <option value="nonactive">Nonactive</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="insert_by">Insert By</label>
                                    <input type="text" class="form-control" id="insert_by"
                                        placeholder="Enter your name" wire:model="insert_by">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="insert_date">Insert Date</label>
                                    <input type="datetime-local" class="form-control" id="insert_date"
                                        wire:model="insert_date">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"
                        wire:click="closeModal">Close</button>
                    <button type="button" class="btn btn-primary" wire:click="store">Save Item</button>
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
                    <h5 class="modal-title" id="modalEditLabel">Edit Inventory Item</h5>
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
                                    <label for="name">Item Name</label>
                                    <input type="text" class="form-control" id="name" wire:model="name">
                                </div>
                                <div class="form-group">
                                    <label for="category_id">Category</label>
                                    <select class="form-control" id="category_id" wire:model="category_id">
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="uom_code">Unit of Measurement</label>
                                    <select class="form-control" id="uom_code" wire:model="uom_code">
                                        @foreach ($uoms as $uom)
                                            <option value="{{ $uom->id }}">{{ $uom->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="price">Price</label>
                                    <input type="number" step="0.01" class="form-control" id="price"
                                        wire:model="price">
                                </div>
                                <div class="form-group">
                                    <label for="stock_minimum">Minimum Stock</label>
                                    <input type="number" class="form-control" id="stock_minimum"
                                        wire:model="stock_minimum">
                                </div>
                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <select class="form-control" id="status" wire:model="status">
                                        <option value="active">Active</option>
                                        <option value="nonactive">Nonactive</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="insert_by">Insert By</label>
                                    <input type="text" class="form-control" id="insert_by"
                                        wire:model="insert_by">
                                </div>
                                <div class="form-group">
                                    <label for="insert_date">Insert Date</label>
                                    <input type="datetime-local" class="form-control" id="insert_date"
                                        wire:model="insert_date">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="last_update_by">Last Update By</label>
                                    <input type="text" class="form-control" id="last_update_by"
                                        wire:model="last_update_by">
                                </div>
                                <div class="form-group">
                                    <label for="last_update_time">Last Update Time</label>
                                    <input type="datetime-local" class="form-control" id="last_update_time"
                                        wire:model="last_update_time">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"
                        wire:click="closeModal">Close</button>
                    <button type="button" class="btn btn-primary" wire:click="update">Update Item</button>
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
