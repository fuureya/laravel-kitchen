<div class="row">
    <div class="col-xl-12 col-lg-12">
        <div class="card shadow mb-4">
            @if (session()->has('message'))
                <div class="alert alert-success">{{ session('message') }}</div>
            @endif
            <div class="card-body py-3">
                <div class="my-5">
                    <h4 class="font-weight-bold text-primary">Unit Of Measurement</h4>
                    @auth
                        @if (in_array('tambah-uoms', auth()->user()->permissions))
                            <button type="button" class="btn btn-primary mt-3" wire:click="openModal" data-toggle="modal"
                                data-target="#modalAdd">
                                <i class="fas fa-plus"></i>
                            </button>
                        @endif
                    @endauth
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered" style="width:100%">
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
                                        @if (in_array('update-uoms', auth()->user()->permissions))
                                            <button wire:click="edit({{ $uom->id }})" class="btn"
                                                data-toggle="modal" data-target="#modalEdit"> <i
                                                    class="fas fa-edit text-success"></i>
                                            </button>
                                        @endif
                                        @if (in_array('hapus-uoms', auth()->user()->permissions))
                                            <button wire:click="delete({{ $uom->id }})" class="btn"
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
                    {{ $uoms->links() }}
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tambah -->
    <div class="modal fade" id="modalAdd" data-backdrop="static" data-keyboard="false" tabindex="-1"
        aria-labelledby="modalAddLabel" aria-hidden="true" wire:ignore.self>
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
                    <button type="button" class="btn btn-primary" wire:click='store()'>Save
                        Changes</button>
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
