<div class="row">
    <div class="col-xl-12 col-lg-12">
        <div class="card shadow mb-4">
            @if (session()->has('message'))
                <div class="alert alert-success">{{ session('message') }}</div>
            @endif
            <div class="card-body py-3">
                <div class="my-5">
                    <h4 class="font-weight-bold text-primary">Sales</h4>

                    <button type="button" class="btn btn-primary mt-3" data-toggle="modal" data-target="#modalAdd">
                        <i class="fas fa-plus"></i> Add New
                    </button>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Supplier</th>
                                <th>Date</th>
                                <th>Remark</th>
                                <th>Void Status</th>
                                <th>Insert By</th>
                                <th>Insert Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $sale)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $sale->supplier->name }}</td>
                                    <td>{{ $sale->date }}</td>
                                    <td>{{ $sale->remark }}</td>
                                    <td>{{ $sale->void_status }}</td>
                                    <td>{{ $sale->insert_by }}</td>
                                    <td>{{ $sale->insert_date }}</td>
                                    <td>
                                        <button class="btn" wire:click='printSale({{ $sale->id }})'>
                                            <i class="fas fa-print text-success"></i>
                                        </button>
                                        <button wire:click="showDetail('{{ $sale->id }}')" class="btn"
                                            data-toggle="modal" data-target="#modalShowDetail">
                                            <i class="fas fa-eye text-primary"></i>
                                        </button>
                                        @if (in_array('update-sales', auth()->user()->permissions))
                                            <button wire:click="edit('{{ $sale->id }}')" class="btn"
                                                data-toggle="modal" data-target="#modalEdit">
                                                <i class="fas fa-edit text-success"></i>
                                            </button>
                                        @endif
                                        <button wire:click="delete('{{ $sale->id }}')" class="btn"
                                            wire:confirm="Yakin Ingin Menghapus?">
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
                    {{-- {{ $sales->links() }} --}}
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Add Sales -->
    <div wire:ignore.self class="modal fade" id="modalAdd" data-backdrop="static" data-keyboard="false" tabindex="-1"
        aria-labelledby="modalAddLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalAddLabel">Add New Sale</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="modal-body">
                    <form wire:submit.prevent="store">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="date">Date</label>
                                <input type="date" class="form-control" id="date" wire:model="date" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="supplier">Supplier</label>
                                <select class="form-control" id="supplier" wire:model="suppliersID" required>
                                    <option value="">Select Supplier</option>
                                    @foreach ($suppliers as $supplier)
                                        <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="remark">Remark</label>
                            <textarea class="form-control" id="remark" rows="3" wire:model="remark"></textarea>
                        </div>

                        <div class="form-group">
                            <label for="void">Void</label>
                            <select class="form-control" id="void" wire:model="void" required>
                                <option value="">Select Void</option>
                                <option value="Y">Yes</option>
                                <option value="N">No</option>

                            </select>
                        </div>

                        <hr>
                        <h5>Sale Items</h5>

                        <button type="button" class="btn btn-primary mb-3" data-toggle="modal"
                            data-target="#modalAddItem">
                            <i class="fas fa-plus"></i> Add Item
                        </button>

                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Quantity</th>
                                        <th>Price</th>
                                        <th>Total</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- @foreach ($saleItems as $index => $item)
                                        <tr>
                                            <td>{{ $item['product_name'] }}</td>
                                            <td>{{ $item['qty'] }}</td>
                                            <td>{{ number_format($item['price'], 2) }}</td>
                                            <td>{{ number_format($item['qty'] * $item['price'], 2) }}</td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-danger"
                                                    wire:click="removeItem({{ $index }})">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach --}}
                                </tbody>
                            </table>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary"
                                {{ $saveState == 'true' ? '' : 'disabled' }}>Save Sale</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Add Item -->
    <div wire:ignore.self class="modal fade" id="modalAddItem" data-backdrop="static" data-keyboard="false"
        tabindex="-1" aria-labelledby="modalAddItemLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl ">
            <div class="modal-content ">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalAddItemLabel">Add Sale Item</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="addItem">
                        <div class="form-group">
                            <label for="product">Product</label>
                            <select class="form-control" id="product" wire:model.live="productID" required>
                                <option value="">Select Product</option>
                                @foreach ($products as $product)
                                    <option value="{{ $product->id }}">{{ $product->product_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="quantity">Quantity</label>
                            <input type="number" class="form-control" id="quantity" wire:model.live="quantity"
                                required min="1">
                        </div>
                        <div class="form-group">
                            <label for="price">Price</label>
                            <input type="number" class="form-control" id="price" wire:model.live="price"
                                required>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary" data-dismiss="modal">Add
                                Item</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <!-- Modal Show Detail -->
    <div wire:ignore.self class="modal fade" id="modalShowDetail" data-backdrop="static" data-keyboard="false"
        tabindex="-1" aria-labelledby="modalShowDetailLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalShowDetailLabel">Sale Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h5>Sale Information</h5>
                            <p><strong>Date:</strong> {{ $saleDetail->date ?? '' }}</p>
                            <p><strong>Supplier:</strong> {{ $saleDetail->supplier->name ?? '' }}</p>
                            <p><strong>Remark:</strong> {{ $saleDetail->remark ?? '' }}</p>
                        </div>
                        <div class="col-md-6">
                            <h5>Status</h5>
                            <p><strong>Void Status:</strong> {{ $saleDetail->void_status ?? '' }}</p>
                            <p><strong>Insert By:</strong> {{ $saleDetail->insert_by ?? '' }}</p>
                            <p><strong>Insert Date:</strong> {{ $saleDetail->insert_date ?? '' }}</p>
                        </div>
                    </div>

                    <h5>Sale Items</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Quantity</th>
                                    <th>Price</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- @foreach ($saleItemsDetail as $item)
                                    <tr>
                                        <td>{{ $item->product->name }}</td>
                                        <td>{{ $item->qty }}</td>
                                        <td>{{ number_format($item->price, 2) }}</td>
                                        <td>{{ number_format($item->qty * $item->price, 2) }}</td>
                                    </tr>
                                @endforeach --}}
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit -->
    <div wire:ignore.self class="modal fade" id="modalEdit" data-backdrop="static" data-keyboard="false"
        tabindex="-1" aria-labelledby="modalEditLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEditLabel">Edit Sale</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="modal-body">
                    <form wire:submit.prevent="update">
                        <input type="hidden" wire:model="sale_id">

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="edit_date">Date</label>
                                <input type="date" class="form-control" id="edit_date" wire:model="date"
                                    required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="edit_supplier">Supplier</label>
                                <select class="form-control" id="edit_supplier" wire:model="suppliers_id" required>
                                    <option value="">Select Supplier</option>
                                    {{-- @foreach ($suppliers as $supplier)
                                        <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                    @endforeach --}}
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="edit_remark">Remark</label>
                            <textarea class="form-control" id="edit_remark" rows="3" wire:model="remark"></textarea>
                        </div>

                        <div class="form-group">
                            <label for="edit_void_status">Void Status</label>
                            <select class="form-control" id="edit_void_status" wire:model="void_status" required>
                                <option value="N">No</option>
                                <option value="Y">Yes</option>
                            </select>
                        </div>

                        <hr>
                        <h5>Sale Items</h5>

                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Quantity</th>
                                        <th>Price</th>
                                        <th>Total</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- @foreach ($saleItems as $index => $item)
                                        <tr>
                                            <td>{{ $item['product_name'] }}</td>
                                            <td>{{ $item['qty'] }}</td>
                                            <td>{{ number_format($item['price'], 2) }}</td>
                                            <td>{{ number_format($item['qty'] * $item['price'], 2) }}</td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-danger"
                                                    wire:click="removeItem({{ $index }})">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach --}}
                                </tbody>
                            </table>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Update Sale</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        document.addEventListener('livewire:load', function() {
            Livewire.on('saleSaved', () => {
                $('#modalAdd').modal('hide');
                $('#modalAddItem').modal('hide');
            });

            Livewire.on('saleUpdated', () => {
                $('#modalEdit').modal('hide');
            });

            Livewire.on('itemAdded', () => {
                $('#modalAddItem').modal('hide');
            });
        });
    </script>
@endpush
