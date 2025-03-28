<div class="row">
    <div class="col-xl-12 col-lg-12">
        <div class="card shadow mb-4">
            @if (session()->has('message'))
                <div class="alert alert-success">{{ session('message') }}</div>
            @endif
            <div class="card-body py-3">
                <div class="my-5">
                    <h4 class="font-weight-bold text-primary">Kelola User</h4>
                    <button type="button" class="btn btn-primary mt-3" data-toggle="modal" data-target="#modalAdd">
                        <i class="fas fa-plus"></i> Tambah User
                    </button>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Username</th>
                                <th>Group</th>
                                <th>Permissions</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $index => $user)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->username }}</td>
                                    <td>{{ $user->group }}</td>
                                    <td>
                                        @php
                                            $permissions = json_decode($user->permissions, true);
                                            if (
                                                is_array($permissions) &&
                                                count($permissions) === 1 &&
                                                is_array($permissions[0])
                                            ) {
                                                $permissions = $permissions[0]; // Ambil array pertama jika bersarang
                                            }
                                        @endphp
                                        {{ implode(', ', $permissions) }}
                                    </td>


                                    <td>
                                        <button class="btn" wire:click="edit({{ $user->id }})"
                                            data-toggle="modal" data-target="#modalEdit">
                                            <i class="fas fa-edit text-success"></i>
                                        </button>
                                        <button class="btn" wire:click="delete({{ $user->id }})"
                                            onclick="confirm('Yakin ingin menghapus user ini?') || event.stopImmediatePropagation()">
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
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>

    <!-- Add User Modal -->
    <div class="modal fade" id="modalAdd" data-backdrop="static" data-keyboard="false" tabindex="-1"
        aria-labelledby="modalAddLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalAddLabel">Tambah User Baru</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                        wire:click="resetForm">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label for="name">Nama Lengkap</label>
                            <input type="text" class="form-control" id="name"
                                placeholder="Masukkan nama lengkap" wire:model="name">
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" class="form-control" id="username" placeholder="Masukkan username"
                                wire:model="username">
                            @error('username')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" id="password" placeholder="Masukkan password"
                                wire:model="password">
                            @error('password')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="group">Group</label>
                            <select class="form-control" id="group" wire:model="group">
                                <option value="">Pilih Group</option>
                                @foreach ($groups as $gp)
                                    <option value="{{ $gp->name }}">{{ $gp->name }}</option>
                                @endforeach
                            </select>
                            @error('group')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"
                        wire:click="resetForm">Tutup</button>
                    <button type="button" class="btn btn-primary" wire:click="store">Simpan User</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit User Modal -->
    <div class="modal fade" id="modalEdit" data-backdrop="static" data-keyboard="false" tabindex="-1"
        aria-labelledby="modalEditLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEditLabel">Edit User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                        wire:click="resetForm">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label for="name">Nama Lengkap</label>
                            <input type="text" class="form-control" id="name" wire:model="name">
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" class="form-control" id="username" wire:model="username"
                                readonly>
                        </div>
                        <div class="form-group">
                            <label for="password">Password (Kosongkan jika tidak diubah)</label>
                            <input type="password" class="form-control" id="password"
                                placeholder="Biarkan kosong jika tidak ingin mengubah" wire:model="password">
                            @error('password')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="group">Group</label>
                            <select class="form-control" id="group" wire:model="group">
                                <option value="">Pilih Group</option>
                                @foreach ($groups as $gp)
                                    <option value="{{ $gp->name }}">{{ $gp->name }}</option>
                                @endforeach
                            </select>
                            @error('group')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"
                        wire:click="resetForm">Tutup</button>
                    <button type="button" class="btn btn-primary" wire:click="update">Update User</button>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        Livewire.on('closeModal', () => {
            $('#modalAdd, #modalEdit').modal('hide');
        });

        Livewire.on('openModalEdit', () => {
            $('#modalEdit').modal('show');
        });
    </script>
@endpush
