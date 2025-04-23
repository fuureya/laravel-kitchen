<!-- resources/views/livewire/products.blade.php -->
<div class="row">
    <div class="col-xl-12 col-lg-12">
        <div class="card shadow mb-4">
            @if (session()->has('message'))
                <div class="alert alert-success">{{ session('message') }}</div>
            @endif
            <div class="card-body py-3">
                <div class="my-5">
                    <h4 class="font-weight-bold text-primary">Products</h4>

                    <button type="button" class="btn btn-primary mt-3" data-toggle="modal" data-target="#modalAdd">
                        <i class="fas fa-plus"></i> Add Product
                    </button>

                </div>
                <div class="table-responsive" style="overflow-x: auto">
                    <table class="table table-bordered " style="width:100%; white-space: nowrap;">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Product Name</th>
                                <th>Price</th>
                                <th>Insert By</th>
                                <th>Insert Time</th>
                                <th>Last Update By</th>
                                <th>Last Update Time</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $product)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $product->product_name }}</td>
                                    <td>Rp. {{ number_format($product->price, 0, ',', '.') }}</td>
                                    <td>{{ $product->insert_by }}</td>
                                    <td>{{ $product->insert_date }}</td>
                                    <td>{{ $product->last_update_by }}</td>
                                    <td>{{ $product->last_update_time }}</td>
                                    <td>

                                        <button wire:click="edit({{ $product->id }})" class="btn"
                                            data-toggle="modal" data-target="#modalEdit"><i
                                                class="fas fa-edit text-success"></i></button>
                                        <button wire:click="delete({{ $product->id }})" class="btn"
                                            wire:confirm="Yakin Ingin Menghapus?"><i
                                                class="fas fa-trash text-danger"></i></button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="mt-4">
                    {{ $data->links() }}
                </div>
            </div>
        </div>
    </div>

    <!-- Add Modal -->
    <div class="modal fade" id="modalAdd" data-backdrop="static" data-keyboard="false" tabindex="-1"
        aria-labelledby="modalAddLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalAddLabel">Add New Product</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                        wire:click="closeModal">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label for="product_name">Product Name</label>
                            <input type="text" class="form-control" id="product_name" placeholder="Enter Name"
                                wire:model="name">
                        </div>
                        <div class="form-group">
                            <label for="price">Price</label>
                            <input type="number" class="form-control" id="price" placeholder="Enter Price"
                                wire:model="price">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"
                        wire:click="closeModal">Close</button>
                    <button type="button" class="btn btn-primary" wire:click="store">Save Product</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="modalEdit" data-backdrop="static" data-keyboard="false" tabindex="-1"
        aria-labelledby="modalEditLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEditLabel">Edit Product</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                        wire:click="closeModal">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label for="product_name">Product Name</label>
                            <input type="text" class="form-control" id="product_name" placeholder="Enter Name"
                                wire:model="name">
                        </div>
                        <div class="form-group">
                            <label for="price">Price</label>
                            <input type="number" class="form-control" id="price" placeholder="Enter Price"
                                wire:model="price">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"
                        wire:click="closeModal">Close</button>
                    <button type="button" class="btn btn-primary" wire:click="update">Update Product</button>
                </div>
            </div>
        </div>
    </div>
</div>

@script
    <script>
        document.addEventListener('livewire:initialized', () => {

            Livewire.on('formSubmitted', () => {
                $('#modalAdd').modal('hide');
            });

            Livewire.on('editSubmitted', () => {
                $('#modalEdit').modal('hide');
            });
        });
    </script>
@endscript
