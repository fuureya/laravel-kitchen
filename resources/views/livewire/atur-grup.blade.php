<div class="row">
    <div class="col-xl-12 col-lg-12">
        <div class="card shadow mb-4">
            @if (session()->has('message'))
                <div class="alert alert-success">{{ session('message') }}</div>
            @endif
            <div class="card-body py-3">
                <div class="my-5">
                    <h4 class="font-weight-bold text-primary">Kelola Grup</h4>
                    @if (in_array('tambah-atur-grup', auth()->user()->permissions))
                        <button type="button" class="btn btn-primary mt-3" data-toggle="modal" data-target="#modalAdd">
                            <i class="fas fa-plus"></i> Tambah Grup
                        </button>
                    @endif
                </div>
                <div class="table-responsive" style="overflow-x: auto">
                    <table class="table table-bordered " style="width:100%; white-space: nowrap;">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Grup</th>
                                <th>Perizinan</th>
                                <th>Dibuat Tanggal</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($grupList as $index => $grup)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $grup->name }}</td>
                                    <td>{{ implode(', ', json_decode($grup->permissions, true) ?? []) }}</td>
                                    <td>{{ $grup->created_at }}</td>
                                    <td>
                                        @if (in_array('update-atur-grup', auth()->user()->permissions))
                                            <button wire:click="edit({{ $grup->id }})" class="btn"
                                                data-toggle="modal" data-target="#modalEdit">
                                                <i class="fas fa-edit text-success"></i>
                                            </button>
                                        @endif
                                        @if (in_array('hapus-atur-grup', auth()->user()->permissions))
                                            <button wire:click="delete({{ $grup->id }})" class="btn"
                                                wire:confirm="Are you sure you want to delete this item?">
                                                <i class="fas fa-trash text-danger"></i>
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{-- Pagination (Jika diperlukan) --}}
                </div>
            </div>
        </div>
    </div>

    <!-- Add Grup Modal -->
    <div class="modal fade" id="modalAdd" tabindex="-1" aria-labelledby="modalAddLabel" aria-hidden="true"
        wire:ignore.self>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalAddLabel">Tambah Grup</h5>
                    <button type="button" class="close" data-dismiss="modal" wire:click="resetForm">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label>Nama Grup</label>
                            <input type="text" class="form-control" wire:model="name">
                        </div>

                        <div class="row">
                            @foreach ($hakAksesList as $index => $item)
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" wire:model="permissions"
                                            value="{{ $item->name }}" id="check{{ $item->id }}">
                                        <label class="form-check-label"
                                            for="check{{ $item->id }}">{{ $item->name }}</label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"
                        wire:click="resetForm">Tutup</button>
                    <button type="button" class="btn btn-primary" wire:click="store">Simpan</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Grup Modal -->
    <div class="modal fade" id="modalEdit" tabindex="-1" aria-labelledby="modalEditLabel" aria-hidden="true"
        wire:ignore.self>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Grup</h5>
                    <button type="button" class="close" data-dismiss="modal" wire:click="resetForm">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label>Nama Grup</label>
                            <input type="text" class="form-control" wire:model="name">
                        </div>

                        <div class="row">
                            @foreach ($hakAksesList as $index => $item)
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" wire:model="permissions"
                                            value="{{ $item->name }}">
                                        <label class="form-check-label">{{ $item->name }}</label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"
                        wire:click="resetForm">Tutup</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal"
                        wire:click="resetPermissions">Reset Permission</button>
                    <button type="button" class="btn btn-success" wire:click="update">Update</button>
                </div>
            </div>
        </div>
    </div>
</div>

@script
    <script>
        Livewire.on('formSubmitted', () => {
            $('#modalAdd').modal('hide');
        });

        Livewire.on('editSubmitted', () => {
            $('#modalEdit').modal('hide');
        });
    </script>
@endscript
