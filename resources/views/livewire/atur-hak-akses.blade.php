<div class="row">
    <div class="col-xl-12 col-lg-12">
        <div class="card shadow mb-4">
            @if (session()->has('message'))
                <div class="alert alert-success">{{ session('message') }}</div>
            @endif
            <div class="card-body py-3">
                <div class="my-5">
                    <h4 class="font-weight-bold text-primary">Kelola Hak Akses</h4>
                    @if (in_array('view-hak-akses', auth()->user()->permissions))
                        <button type="button" class="btn btn-primary mt-3" data-toggle="modal" data-target="#modalAdd">
                            <i class="fas fa-plus"></i>
                        </button>
                    @endif
                </div>
                <div class="table-responsive" style="overflow-x: auto">
                    <table class="table table-bordered " style="width:100%; white-space: nowrap;">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Hak Akses</th>
                                <th>Dibuat Tanggal</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($hakAksesList as $index => $item)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->created_at->format('Y-m-d H:i') }}</td>
                                    <td>
                                        @if (in_array('update-hak-akses', auth()->user()->permissions))
                                            <button wire:click="edit({{ $item->id }})" class="btn btn-success"
                                                data-toggle="modal" data-target="#modalEdit">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                        @endif
                                        @if (in_array('hapus-hak-akses', auth()->user()->permissions))
                                            <button wire:click="delete({{ $item->id }})" class="btn btn-danger">
                                                <i class="fas fa-trash"></i>
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
                    {{-- Pagination logic here --}}
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
                    <h5 class="modal-title" id="modalAddLabel">Tambah Hak Akses</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                        wire:click="resetForm">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label for="name">Nama Hak Akses</label>
                            <input type="text" class="form-control" id="name" placeholder="Masukkan nama"
                                wire:model="name">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"
                        wire:click="resetForm">Close</button>
                    <button type="button" class="btn btn-primary" wire:click="store">Simpan</button>
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
                    <h5 class="modal-title" id="modalEditLabel">Edit Hak Akses</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                        wire:click="resetForm">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label for="name">Nama Hak Akses</label>
                            <input type="text" class="form-control" id="name" wire:model="name">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"
                        wire:click="resetForm">Close</button>
                    <button type="button" class="btn btn-primary" wire:click="update">Update</button>
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

            Livewire.on('openEditModal', () => {
                $('#modalEdit').modal('show');
            });
        });
    </script>
@endscript
