<div class="row">
    <div class="col-xl-12 col-lg-12">
        <div class="card shadow mb-4">
            @if (session()->has('message'))
                <div class="alert alert-success">{{ session('message') }}</div>
            @endif
            <div class="card-body py-3">
                <div class="my-5">
                    <h4 class="font-weight-bold text-primary">Receive Out</h4>
                    @if (in_array('tambah-receiving', auth()->user()->permissions))
                        <button type="button" class="btn btn-primary mt-3" data-toggle="modal" data-target="#modalAdd">
                            <i class="fas fa-plus"></i>
                        </button>
                    @endif



                </div>
                <div class="table-responsive">
                    <table class="table table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Receiving ID</th>
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
                            {{-- @foreach ($data as $datas)
                                <tr>
                                    <td>{{ $datas->id }}</td>
                                    <td>{{ $datas->receiving_id }}</td>
                                    <td>{{ $datas->date }}</td>
                                    <td>{{ $datas->remark }}</td>
                                    <td>{{ $datas->supplier->name }}</td>
                                    <td>{{ $datas->insert_by }}</td>
                                    <td>{{ $datas->insert_date }}</td>
                                    <td>{{ $datas->last_update_by }}</td>
                                    <td>{{ $datas->last_update_time }}</td>
                                    <td>
                                        <button class="btn" wire:click='printing({{ $datas->id }})'>
                                            <i class="fas fa-print text-success"></i>
                                        </button>
                                        <button wire:click="showDetail('{{ $datas->receiving_id }}')" class="btn"
                                            data-toggle="modal" data-target="#modalShowDetail"> <i
                                                class="fas fa-eye text-primary"></i>
                                        </button>
                                        @if (in_array('update-receiving', auth()->user()->permissions))
                                            <button wire:click="edit('{{ $datas->receiving_id }}')" class="btn"
                                                data-toggle="modal" data-target="#modalEdit"> <i
                                                    class="fas fa-edit text-success"></i>
                                            </button>
                                        @endif
                                        @if (in_array('hapus-receiving', auth()->user()->permissions))
                                            <button wire:click="delete('{{ $datas->receiving_id }}')" class="btn"
                                                wire:confirm="Yakin Ingin Menghapus?"><i
                                                    class="fas fa-trash text-danger"></i></button>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach --}}
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="mt-4">
                    {{-- {{ $data->links() }} --}}
                </div>



            </div>
        </div>
    </div>

    <!-- Modal Tambah -->
    <div wire:ignore.self class="modal fade" id="modalAdd" data-backdrop="static" data-keyboard="false" tabindex="-1"
        aria-labelledby="modalAddLabel" aria-hidden="true">
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
                    <form wire:submit='store'>
                        <div class="form-group">
                            <label for="date">Date</label>
                            <input type="date" class="form-control" id="date" placeholder="Enter date"
                                wire:model='date'>
                        </div>

                        <div class="form-group">
                            <label for="suppliers">Barang</label>
                            <select class="form-control" id="suppliers" wire:model='suppliers'>
                                <option>Pilih Barang</option>
                                @foreach ($barang as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <label for="quantity">Quantity</label>
                        <div class="input-group mb-3">
                            <input type="number" class="form-control" aria-label="Recipient's username"
                                aria-describedby="basic-addon2" wire:model.live='quantity'>
                            <div class="input-group-append">
                                <span class="input-group-text" id="basic-addon2">
                                    {{-- {{ $uoms }} --}}
                                </span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="price_quantity">Price Quantity</label>
                            <input type="number" class="form-control" id="price_quantity"
                                placeholder="Enter Price Quantity" wire:model.live='priceQuantity' disabled>
                        </div>

                        <div class="form-group">
                            <label for="exampleFormControlTextarea1">Remarsk</label>
                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" wire:model='remarks'></textarea>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"
                        wire:click='closeReceiving'>Close</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan Data</button>
                </div>
                </form>



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
                {{-- @if ($errors->any())
                    @foreach ($errors->all() as $error)
                        <div class="alert alert-danger" role="alert">
                            {{ $error }}
                        </div>
                    @endforeach
                @endif --}}

                @if (session()->has('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif
                <div class="modal-body">
                    <form>

                        <label for="inventory">Inventory</label>

                        <div class="input-group mb-3">
                            <select class="custom-select" id="inventory" wire:model.live='inventory' required>
                                <option selected>Pilih Inventory</option>
                                {{-- @foreach ($invent as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</optio>
                                @endforeach --}}
                            </select>

                        </div>


                        <label for="quantity">Quantity</label>
                        <div class="input-group mb-3">
                            <input type="number" class="form-control" aria-label="Recipient's username"
                                aria-describedby="basic-addon2" wire:model.live='quantity'>
                            <div class="input-group-append">
                                <span class="input-group-text" id="basic-addon2">
                                    {{-- {{ $uoms }} --}}
                                </span>
                            </div>
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
                    <button type="button" class="btn btn-primary" wire:click='enableSaving'>Simpan Detail</button>
                </div>
            </div>
        </div>
    </div>

    {{-- show detail receiving --}}
    <div class="modal fade" id="modalShowDetail" data-backdrop="static" data-keyboard="false" tabindex="-1"
        aria-labelledby="modalShowDetailLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEditLabel">Show Detail Record</h5>
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
                        {{-- <p class="badge bg-danger text-white">{{ $receivingID }}</p> --}}
                        <div class="form-group">
                            <label for="inventory">Inventory</label>
                            <select class="form-control" id="inventory" wire:model.live='inventory' disabled>
                                <option>Pilih Inventory</option>
                                {{-- @foreach ($invent as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach --}}
                            </select>
                        </div>


                        <label for="quantity">Quantity</label>
                        <div class="input-group mb-3">
                            <input type="number" class="form-control" aria-label="Recipient's username"
                                aria-describedby="basic-addon2" wire:model.live='quantity' disabled>
                            <div class="input-group-append">
                                <span class="input-group-text" id="basic-addon2">
                                    {{-- {{ $uoms }} --}}
                                </span>
                            </div>
                        </div>



                        <div class="form-group">
                            <label for="price">Price</label>
                            <input type="number" class="form-control" id="price" placeholder="Enter price"
                                wire:model.live='price' disabled>
                        </div>

                        <div class="form-group">
                            <label for="price_quantity">Price Quantity</label>
                            <input type="number" class="form-control" id="price_quantity"
                                placeholder="Enter Price Quantity" wire:model.live='priceQuantity' disabled>
                        </div>
                    </form>
                </div>

                <hr>


                <div class="container">
                    <h5 class="font-weight-bold">Purchase Detail</h5>

                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Paid</th>
                                <th>Purchase</th>
                                <th>Payment</th>
                                <th>Status</th>
                                <th>Insert Time</th>
                                <th>Insert By</th>
                            </tr>
                        </thead>
                        <tbody>

                            {{-- @if ($getAllInventory != null)
                                @foreach ($getAllInventory as $item)
                                    <tr>

                                        <td>Rp. {{ number_format($item->total, 0, ',', '.') }}</td>
                                        <td>{{ $item->purchase }}</td>
                                        <td>{{ $item->payment_name }}</td>
                                        <td>{{ $item->status }}</td>
                                        <td>{{ $item->insert_time }}</td>
                                        <td>{{ $item->insert_by }}</td>
                                    </tr>
                                @endforeach
                            @endif --}}

                        </tbody>
                    </table>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"
                        wire:click='closeDetail'>Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal edit -->
    <div class="modal fade" id="modalEdit" data-backdrop="static" data-keyboard="false" tabindex="-1"
        aria-labelledby="modalEditLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEditLabel">Update Detail Record</h5>
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
                        {{-- <p class="badge bg-danger text-white">{{ $receivingID }}</p> --}}
                        <div class="form-group">
                            <label for="inventory">Inventory</label>
                            <select class="form-control" id="inventory" wire:model.live='inventory'>
                                <option>Pilih Inventory</option>
                                {{-- @foreach ($invent as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</optio>
                                @endforeach --}}
                            </select>
                        </div>

                        <label for="quantity">Quantity</label>
                        <div class="input-group mb-3">
                            <input type="number" class="form-control" aria-label="Recipient's username"
                                aria-describedby="basic-addon2" wire:model.live='quantity'>
                            <div class="input-group-append">
                                <span class="input-group-text" id="basic-addon2">
                                    {{-- {{ $uoms }} --}}
                                </span>
                            </div>
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

                        <br>
                        <hr>

                        <h5 class="font-weight-bold mb-3">Payment Receiving</h5>

                        <div class="form-group">
                            <label for="paid">Amount Paid</label>
                            <input type="paid" class="form-control" id="paid" placeholder="Enter paid"
                                wire:model.live='paid'>
                        </div>

                        <div class="form-group">
                            <label for="purchase">Purchase</label>
                            <select class="form-control" id="purchase" wire:model.live='purchase'>
                                <option>Select Purchase</option>
                                <option value="kredit">Kredit</option>
                                <option value="debit">Debit</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="payment">Payment</label>
                            <select class="form-control" id="payment" wire:model.live='payment'>
                                <option>Select Payment</option>
                                {{-- @foreach ($paymentData as $item)
                                    <option value="{{ $item->payment_name }}">{{ $item->payment_name }}</option>
                                @endforeach --}}
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="status">Status</label>
                            <select class="form-control" id="status" wire:model.live='status'>
                                <option>Pilih Status</option>
                                <option value="lunas">Lunas</option>
                                <option value="belum lunas">Belum Lunas</option>
                            </select>
                        </div>

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"
                        wire:click='closeDetail'>Close</button>
                    <button type="button" class="btn btn-primary" wire:click='update'>Simpan Detail</button>
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

            Livewire.on('formEditSubmitted', () => {
                $('#modalEdit').modal('hide');
            });

            Livewire.on('modalAddDetail', () => {
                $('#modalAddDetail').hide();
            });



        });
    </script>
@endscript
