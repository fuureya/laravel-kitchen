<div class="row">
    <div class="col-xl-12 col-lg-12">
        <div class="card shadow mb-4">
            @if (session()->has('message'))
                <div class="alert alert-success">{{ session('message') }}</div>
            @endif
            @if (session()->has('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            <div class="card-body py-3">
                <div class="my-5">
                    <h4 class="font-weight-bold text-primary">Receive Out</h4>
                    @if (in_array('tambah-receive-out', auth()->user()->permissions))
                        <button type="button" class="btn btn-primary mt-3" data-toggle="modal" data-target="#modalAdd">
                            <i class="fas fa-plus"></i>
                        </button>
                    @endif



                </div>
                @if (in_array('view-receive-out', auth()->user()->permissions))
                    <div class="table-responsive" style="overflow-x: auto">
                        <table class="table table-bordered " style="width:100%; white-space: nowrap;">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Receiving ID</th>
                                    <th>Tanggal</th>
                                    <th>Remark</th>
                                    <th>Inventory</th>
                                    <th>Quantity</th>
                                    <th>Insert By</th>
                                    <th>Insert Date</th>
                                    <th>Last Update By</th>
                                    <th>Last Update Time</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $datas)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $datas->receiving_out_id }}</td>
                                        <td>{{ $datas->date }}</td>
                                        <td>{{ $datas->remark }}</td>
                                        <td>{{ $datas->inventory->name }}</td>
                                        <td>{{ $datas->quantity }}</td>
                                        <td>{{ $datas->insert_by }}</td>
                                        <td>{{ $datas->insert_date }}</td>
                                        <td>{{ $datas->last_update_by }}</td>
                                        <td>{{ $datas->last_update_time }}</td>
                                        <td>

                                            @if (in_array('update-receive-out', auth()->user()->permissions))
                                                <button wire:click="edit('{{ $datas->id }}')" class="btn"
                                                    data-toggle="modal" data-target="#modalEdit"> <i
                                                        class="fas fa-edit text-success"></i>
                                                </button>
                                            @endif
                                            @if (in_array('hapus-receive-out', auth()->user()->permissions))
                                                <button wire:click="delete('{{ $datas->id }}')" class="btn"
                                                    wire:confirm="Yakin Ingin Menghapus?"><i
                                                        class="fas fa-trash text-danger"></i></button>
                                            @endif
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
                @endif
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
                            <select class="form-control" id="suppliers" wire:model='inven'>
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
                            <label for="exampleFormControlTextarea1">Remarsk</label>
                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" wire:model='remarks'></textarea>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"
                        wire:click='closeButton'>Close</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Edit Data</button>
                </div>
                </form>



            </div>
        </div>
    </div>





    <!-- Modal edit -->
    <div class="modal fade" id="modalEdit" data-backdrop="static" data-keyboard="false" tabindex="-1"
        aria-labelledby="modalEditLabel" aria-hidden="true" wire:ignore.self>
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
                    <form wire:submit='update'>
                        <div class="form-group">
                            <label for="date">Date</label>
                            <input type="date" class="form-control" id="date" placeholder="Enter date"
                                wire:model='date'>
                        </div>

                        <div class="form-group">
                            <label for="suppliers">Barang</label>
                            <select class="form-control" id="suppliers" wire:model='inven'>
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
                            <label for="exampleFormControlTextarea1">Remarsk</label>
                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" wire:model='remarks'></textarea>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"
                        wire:click='closeButton'>Close</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan Data</button>
                </div>
                </form>



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
