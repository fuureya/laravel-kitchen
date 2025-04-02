<div class="row">
    <div class="col-xl-12 col-lg-12">
        <div class="card shadow mb-4">
            @if (session()->has('message'))
                <div class="alert alert-success">{{ session('message') }}</div>
            @endif
            <div class="card-body py-3">
                <div class="my-5">
                    <h4 class="font-weight-bold text-primary">Recipes</h4>
                    <button type="button" class="btn btn-primary mt-3" data-toggle="modal" data-target="#modalAdd">
                        <i class="fas fa-plus"></i> Add Recipes
                    </button>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Name Recipes</th>
                                <th>Insert By</th>
                                <th>Insert Time</th>
                                <th>Last Update By</th>
                                <th>Last Update Time</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $rp)
                                <tr>
                                    <td>{{ $rp->id }}</td>
                                    <td>{{ $rp->name }}</td>
                                    <td>{{ $rp->insert_by }}</td>
                                    <td>{{ $rp->insert_time }}</td>
                                    <td>{{ $rp->last_update_by }}</td>
                                    <td>{{ $rp->last_update_time }}</td>
                                    <td>
                                        <div class="d-flex justify-content-center">
                                            <button wire:click="detail({{ $rp->id }})" class="btn"
                                                data-toggle="modal" data-target="#modalDetail"><i
                                                    class="fas fa-eye text-primary"></i></button>
                                            <button wire:click="edit({{ $rp->id }})" class="btn"
                                                data-toggle="modal" data-target="#modalEdit"><i
                                                    class="fas fa-edit text-success"></i></button>
                                            <button wire:click="delete({{ $rp->id }})" class="btn"
                                                wire:confirm="Yakin Ingin Menghapus?"><i
                                                    class="fas fa-trash text-danger"></i></button>
                                        </div>
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
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalAddLabel">Add New R</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                        wire:click="closeModal">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label for="name">Recipe Name</label>
                            <input type="text" class="form-control" id="name" placeholder="Enter Name"
                                wire:model="name">
                        </div>

                        <div class="form-group">
                            <label for="name">Write Recipe</label>
                            <textarea id="recipes" wire:model='recipes'></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"
                        wire:click="closeModal">Close</button>
                    <button type="button" class="btn btn-primary" id="store" wire:click="store()">Save
                        Recipe</button>
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
                    <h5 class="modal-title" id="modalEditLabel">Edit Category</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                        wire:click="closeModal">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label for="name">Category Name</label>
                            <input type="text" class="form-control" id="name" placeholder="Enter Name"
                                wire:model="name">
                        </div>

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"
                        wire:click="closeModal">Close</button>
                    <button type="button" class="btn btn-primary" wire:click="update">Update Category</button>
                </div>
            </div>
        </div>
    </div>


    <!-- Detail Modal -->
    <div class="modal fade" id="modalDetail" data-backdrop="static" data-keyboard="false" tabindex="-1"
        aria-labelledby="modalDetailLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEditLabel">Recipe {{ $name }}</h5>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                        wire:click="closeModal">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {!! $recipes !!}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"
                        wire:click="closeModal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>

@script
    <script>
        $(document).ready(function() {
            // Initialize Summernote only once and ensure it's not destroyed on modal hide
            function initializeSummernote() {
                if ($('#recipes').summernote('isNotInitialized')) {
                    $('#recipes').summernote({
                        tabsize: 2,
                        height: 400,
                        toolbar: [
                            ['style', ['bold', 'italic', 'underline', 'clear']],
                            ['font', ['strikethrough', 'superscript', 'subscript']],
                            ['para', ['ul', 'ol', 'paragraph']],
                            ['insert', ['link', 'picture', 'table']],
                            ['view', ['codeview']]
                        ]
                    });
                }
            }

            // Initialize Summernote when the page is ready
            initializeSummernote();

            // Re-initialize Summernote when modal is shown
            $('#modalAdd').on('shown.bs.modal', function() {
                initializeSummernote(); // Initialize only if not already initialized
            });

            // On 'Store' button click, save the recipes data from Summernote to Livewire
            $('#store').on('click', function() {
                @this.recipes = $('#recipes').val(); // Save the content to Livewire property
            });

            // After form is submitted, close the modal
            Livewire.on('formSubmitted', () => {
                $('#modalAdd').modal('hide');
            });

            // Destroy Summernote when modal is hidden
            $('#modalAdd').on('hidden.bs.modal', function() {
                $('#recipes').summernote('destroy'); // Only destroy if modal is hidden
            });
        });
    </script>
@endscript
