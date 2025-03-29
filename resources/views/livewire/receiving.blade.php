<div class="row">
    <div class="col-xl-12 col-lg-12">
        <div class="card shadow mb-4">
            @if (session()->has('message'))
                <div class="alert alert-success">{{ session('message') }}</div>
            @endif
            <div class="card-body py-3">
                <div class="my-5">
                    <h4 class="font-weight-bold text-primary">Receiving</h4>
                    <button type="button" class="btn btn-primary mt-3" data-toggle="modal" data-target="#modalAdd">
                        <i class="fas fa-plus"></i>
                    </button>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Tanggal</th>
                                <th>Remark</th>
                                <th>Supplier</th>
                                <th>Insert By</th>
                                <th>Insert Date</th>
                                <th>Last Update By</th>
                                <th>Last Update Time</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- @foreach ($uoms as $uom)
                                <tr>
                                    <td>{{ $uom->id }}</td>
                                    <td>{{ $uom->name }}</td>
                                    <td>{{ $uom->insert_by }}</td>
                                    <td>{{ $uom->insert_time }}</td>
                                    <td>{{ $uom->last_update_by }}</td>
                                    <td>{{ $uom->last_update_time }}</td>
                                    <td>
                                        <button wire:click="edit({{ $uom->id }})" class="btn"
                                            data-toggle="modal" data-target="#modalEdit"> <i
                                                class="fas fa-edit text-success"></i>
                                        </button>
                                        <button wire:click="delete({{ $uom->id }})" class="btn"
                                            wire:confirm="Yakin Ingin Menghapus?"><i
                                                class="fas fa-trash text-danger"></i></button>
                                    </td>
                                </tr>
                            @endforeach --}}
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                {{-- <div class="mt-4">
                    {{ $uoms->links() }}
                </div> --}}



            </div>
        </div>
    </div>

    <!-- Modal Tambah -->
    <div class="modal fade" id="modalAdd" data-backdrop="static" data-keyboard="false" tabindex="-1"
        aria-labelledby="modalAddLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEditLabel">Add New Record</h5>
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
                        <small>Receiving Id : <span class="badge bg-danger text-white">12355454</span></small>
                        <div class="form-group">
                            <label for="date">Date</label>
                            <input type="date" class="form-control" id="date" placeholder="Enter date"
                                wire:model='date'>
                        </div>

                        <div class="form-group">
                            <label for="suppliers">Suppliers</label>
                            <select class="form-control" id="suppliers" wire:model='suppliers'>
                                <option>Pilih Suppliers</option>
                                @foreach ($supp as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="exampleFormControlTextarea1">Remarsk</label>
                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" wire:model='remarks'></textarea>
                        </div>
                    </form>

                    <button type="button" class="btn btn-primary mt-3" data-toggle="modal"
                        data-target="#modalAddDetail">
                        <i class="fas fa-plus"></i> Add Details
                    </button>

                    <div class="mt-5 list-detail overflow-auto">
                        <table class="table table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Receiving ID</th>
                                    <th>Inventory ID</th>
                                    <th>Quantity</th>
                                    <th>Price</th>
                                    <th>Price Quantity</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>{{ $receivingID }}</td>
                                    <td>{{ $inventory }}</td>
                                    <td>{{ $quantity }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"
                        wire:click='closeReceiving'>Close</button>
                    <button type="button" class="btn btn-primary" wire:click='store()'>Simpan Data</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Detail -->
    <div class="modal fade" id="modalAddDetail" data-backdrop="static" data-keyboard="false" tabindex="-1"
        aria-labelledby="modalAddDetailLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEditLabel">Add Detail Record</h5>
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
                    <small>Receiving Id : <span class="badge bg-danger text-white">12355454</span></small>
                    <form>

                        <div class="form-group">
                            <label for="inventory">Inventory</label>
                            <select class="form-control" id="inventory">
                                <option>Pilih Inventory</option>
                                @foreach ($invent as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="quantity">Quantity</label>
                            <input type="number" class="form-control" id="quantity" placeholder="Enter quantity"
                                wire:model.live='quantity'>
                        </div>

                        <div class="form-group">
                            <label for="price">Price</label>
                            <input type="number" class="form-control" id="price" placeholder="Enter price"
                                wire:model.live='price'>
                        </div>

                        <div class="form-group">
                            <label for="price_quantity">Price Quantity</label>
                            <input type="number" class="form-control" id="price_quantity"
                                placeholder="Enter Price Quantity" wire:model.live='priceQuantity' disabled>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"
                        wire:click='closeDetail'>Close</button>
                    <button type="button" class="btn btn-primary">Simpan Data</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal edit -->
    <div class="modal fade" id="modalEdit" data-backdrop="static" data-keyboard="false" tabindex="-1"
        aria-labelledby="modalEditLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEditLabel">Add New Record</h5>
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

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"
                        wire:click='closeModal'>Close</button>
                    <button type="button" class="btn btn-primary" wire:click='update()'>Save
                        Changes</button>
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
