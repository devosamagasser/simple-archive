@extends('layouts.app')

@section('content')

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Home</h1>
        <form method="GET" action="{{ route('home') }}" class="mb-4">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Search folders and files..." value="{{ request('search') }}">
                <div class="input-group-append">
                    <button class="btn btn-primary" type="submit"><i class="fas fa-search"></i> Search</button>
                </div>
            </div>
        </form>
        <div class="btn-group">
            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                <i class="fas fa-folder-plus fa-sm text-white-50"></i> Create
            </button>
            <ul class="dropdown-menu">
                <li>
                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#createFolderModal">
                        <i class="fas fa-folder fa-sm fa-fw mr-2 text-gray-400"></i> Folder
                    </a>
                </li>
                <li>
                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#createFileModal">
                        <i class="fas fa-file fa-sm fa-fw mr-2 text-gray-400"></i> File
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <!-- Create Folder Modal -->
    <div class="modal fade" id="createFolderModal" tabindex="-1" role="dialog" aria-labelledby="createFolderModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content shadow-lg">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="createFolderModalLabel">Create New Folder</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form action="{{ route('folders.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="folderName">Folder Name</label>
                            <input type="text" name="name" id="folderName" class="form-control" placeholder="Enter folder name" required>
                        </div>

                        <div class="form-group">
                            <label for="folderStatus">Status</label>
                            <select name="status" id="folderStatus" class="form-control">
                                <option value="public">Public</option>
                                <option value="private">Private</option>
                            </select>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Create</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Create File Modal -->
    <div class="modal fade" id="createFileModal" tabindex="-1" role="dialog" aria-labelledby="createFileModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content shadow-lg">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="createFileModalLabel">Create New File</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form action="{{ route('files.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="fileName">File Name</label>
                            <input type="text" name="name" id="fileName" class="form-control" placeholder="Enter file name" required>
                        </div>
                        <div class="form-group">
                            <label for="fileSDesc">Short description</label>
                            <input type="text" name="short_description" id="fileSDesc" class="form-control" placeholder="Enter file short description">
                        </div>
                        {{-- <div class="form-group">
                            <label for="fileLDesc">Long description</label>
                            <textarea name="long_description" id="fileLDesc" cols="30" rows="5" class="form-control" placeholder="Enter long description"></textarea>
                        </div> --}}
                        <div class="form-group">
                            <label for="folderStatus">Status</label>
                            <select name="status" id="folderStatus" class="form-control">
                                <option value="public" selected>Public</option>
                                <option value="private">Private</option>
                            </select>
                        </div>
                        {{-- <div class="form-group">
                            <label for="folderStatus">Type</label>
                            <select name="type" id="folderStatus" class="form-control">
                                <option value="image" selected>image</option>
                                <option value="video">video</option>
                                <option value="audio">audio</option>
                                <option value="document">document</option>
                                <option value="other">other</option>
                            </select>
                        </div> --}}

                        <div class="form-group">
                            <label for="fileUpload">Upload File</label>
                            <input type="file" name="file" id="fileUpload" class="form-control-file" required>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Upload</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Content Row -->
    <div class="row">
        <!-- Folders Section -->
        <div class="col-lg-12 mb-4">
            <h3>Folders</h3>
            <div class="row">
                @foreach($folders as $folder)
                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 mb-4">
                    <div class="card bg-primary text-white shadow folder-card position-relative">
                        <!-- Badge في أعلى اليسار -->
                        <span class="badge position-absolute" 
                            style="bottom: 8px; right: 5px; padding: 5px 10px;">
                            @if($folder->status == 'public')
                                <i class="fas fa-globe fa-lg"></i>
                            @else
                            <i class="fas fa-lock fa-lg"></i>
                            @endif
                        </span>
                
                        <!-- زر الثلاث نقاط بتصميم بسيط وأنيق -->
                        <div class="dropdown position-absolute" style="top: 8px; right: 5px;">
                            <button class="btn btn-transparent text-white" type="button" id="dropdownMenuButton{{ $folder->id }}" 
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="font-size: 1.2rem;">
                                <i class="fas fa-ellipsis-v"></i>
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $folder->id }}">
                                <a class="dropdown-item text-primary" href="#" data-toggle="modal" data-target="#editFolderModal{{ $folder->id }}">
                                    Edit
                                </a>
                                <form action="{{ route('folders.destroy', $folder->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="dropdown-item text-danger">Delete</button>
                                </form>
                            </div>
                        </div>
                
                        <div class="card-body d-flex align-items-start justify-content-between flex-column" style="height: 100px;">
                            <div class="d-flex align-items-center">
                                <a href="{{ route('folders.show', $folder->id) }}" class="text-white d-flex align-items-center text-decoration-none" title="{{ $folder->name }}">
                                    <i class="fas fa-folder fa-3x mr-3"></i>
                                    <span class="h5 mb-0 text-truncate" style="max-width: 150px; display: inline-block; overflow: hidden; white-space: nowrap; text-overflow: ellipsis;">{{ $folder->name }}</span>
                                </a>
                            </div>
                
                            <!-- تاريخ الإنشاء في أسفل اليمين -->
                            <small class="position-absolute text-white-50" style="bottom: 5px; left: 12px;">
                                {{ $folder->created_at->format('Y-m-d') }}
                            </small>
                        </div>
                    </div>
                
                    <!-- Modal لتعديل المجلد -->
                    <div class="modal fade" id="editFolderModal{{ $folder->id }}" tabindex="-1" role="dialog" 
                        aria-labelledby="editFolderModalLabel{{ $folder->id }}" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content shadow-lg">
                                <div class="modal-header bg-primary text-white">
                                    <h5 class="modal-title" id="editFolderModalLabel{{ $folder->id }}">Edit Folder</h5>
                                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                
                                <form action="{{ route('folders.update', $folder->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label for="folderName{{ $folder->id }}">Folder Name</label>
                                            <input type="text" name="name" id="folderName{{ $folder->id }}" 
                                                class="form-control" value="{{ $folder->name }}" required>
                                        </div>
                
                                        <div class="form-group">
                                            <label for="folderStatus{{ $folder->id }}">Status</label>
                                            <select name="status" id="folderStatus{{ $folder->id }}" class="form-control">
                                                <option value="public" {{ $folder->status == 'public' ? 'selected' : '' }}>Public</option>
                                                <option value="private" {{ $folder->status == 'private' ? 'selected' : '' }}>Private</option>
                                            </select>
                                        </div>
                                    </div>
                
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                        <button type="submit" class="btn btn-primary">Save Changes</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Files Section -->
        <div class="col-lg-12 mb-4">
            @if ($files)
            <h3>Files</h3>
            @endif
            <div class="row">
                @foreach($files as $file)
                    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 mb-4">
                        <div class="card bg-secondary text-white shadow file-card position-relative">
                            <span class="badge position-absolute" 
                                style="bottom: 8px; right: 5px; padding: 5px 10px;">
                                @if($file->status == 'public')
                                    <i class="fas fa-globe fa-lg"></i>
                                @else
                                    <i class="fas fa-lock fa-lg"></i>
                                @endif
                            </span>
                    
                            <div class="dropdown position-absolute" style="top: 8px; right: 5px;">
                                <button class="btn btn-transparent text-white" type="button" id="dropdownMenuButton{{ $file->id }}" 
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="font-size: 1.2rem;">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $file->id }}">
                                    <!-- تعديل الملف -->
                                    <a class="dropdown-item text-primary" href="#" data-toggle="modal" data-target="#editFileModal{{ $file->id }}">
                                        Edit
                                    </a>
                            
                                    <!-- تحميل الملف -->
                                    <a class="dropdown-item text-success" href="{{ route('files.download', $file->id) }}">
                                        <i class="fas fa-download"></i> Download
                                    </a>
                            
                                    <!-- مشاركة الملف -->
                                    @if($file->status == 'public')
                                        <button class="dropdown-item text-info copy-link-btn" 
                                                data-link="{{ route('files.show', $file->id) }}">
                                            <i class="fas fa-share"></i> Share
                                        </button>
                                    @else
                                        <button class="dropdown-item text-warning" data-toggle="modal" 
                                                data-target="#shareFileModal{{ $file->id }}">
                                            <i class="fas fa-user-plus"></i> Share with Users
                                        </button>
                                    @endif
                                
                            
                                    <!-- حذف الملف -->
                                    <form action="{{ route('files.destroy', $file->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="dropdown-item text-danger">
                                            <i class="fas fa-trash-alt"></i> Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                            
                    
                            <div class="card-body d-flex align-items-start justify-content-between flex-column" style="height: 100px;">
                                <div class="d-flex align-items-center">
                                    <a href="{{ route('files.show', $file->id) }}" class="text-white d-flex align-items-center text-decoration-none" >
                                        <i class="fas fa-file fa-3x mr-3"></i>
                                        <div>
                                            <span class="h5 mb-0 text-truncate" 
                                                style="max-width: 150px;" 
                                                title="{{ $file->name }}">
                                                {{ Str::limit($file->name, 20, '...') }}
                                            </span>
                                        </div>
                                    </a>
                                </div>
                                
                                <!-- تاريخ الإنشاء في أسفل اليمين -->
                                <small class="position-absolute text-white-50" style="bottom: 5px; left: 12px;">
                                    {{ $file->created_at->format('Y-m-d') }}
                                </small>
                                <div class="w-100 bg-dark text-center text-white-50 py-1" style="position: absolute; top: 95%; left: 0;">
                                    {{ ucfirst($file->type) }}
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- edit model --}}
                    <div class="modal fade" id="editFileModal{{ $file->id }}" tabindex="-1" role="dialog" 
                        aria-labelledby="editFileModalLabel{{ $file->id }}" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content shadow-lg">
                                <div class="modal-header bg-primary text-white">
                                    <h5 class="modal-title" id="editFileModalLabel{{ $file->id }}">Edit File</h5>
                                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                @if($file->type == 'image')
                                    <div class="form-group text-center">
                                        <label>Current Image</label>
                                        <br>
                                        <img src="{{ asset('storage/' . $file->path) }}" 
                                            alt="{{ $file->name }}" 
                                            class="img-fluid rounded shadow" 
                                            style="max-width: 100%; height: auto;">
                                    </div>
                                @endif

                                <form action="{{ route('files.update', $file->id) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label for="fileName{{ $file->id }}">File Name</label>
                                            <input type="text" name="name" id="fileName{{ $file->id }}" 
                                                    class="form-control" value="{{ $file->name }}" required>
                                        </div>
                    
                                        <div class="form-group">
                                            <label for="fileSDesc{{ $file->id }}">Short Description</label>
                                            <input type="text" name="short_description" id="fileSDesc{{ $file->id }}"
                                                    class="form-control" value="{{ $file->short_description }}">
                                        </div>
                    
                                        {{-- <div class="form-group">
                                            <label for="fileLDesc{{ $file->id }}">Long Description</label>
                                            <textarea name="long_description" id="fileLDesc{{ $file->id }}" 
                                                        cols="30" rows="5" class="form-control">{{ $file->long_description }}</textarea>
                                        </div> --}}
                    
                                        <div class="form-group">
                                            <label for="fileStatus{{ $file->id }}">Status</label>
                                            <select name="status" id="fileStatus{{ $file->id }}" class="form-control">
                                                <option value="public" {{ $file->status == 'public' ? 'selected' : '' }}>Public</option>
                                                <option value="private" {{ $file->status == 'private' ? 'selected' : '' }}>Private</option>
                                            </select>
                                        </div>
                    
                                        {{-- <div class="form-group">
                                            <label for="fileType{{ $file->id }}">Type</label>
                                            <select name="type" id="fileType{{ $file->id }}" class="form-control">
                                                <option value="image" {{ $file->type == 'image' ? 'selected' : '' }}>Image</option>
                                                <option value="video" {{ $file->type == 'video' ? 'selected' : '' }}>Video</option>
                                                <option value="audio" {{ $file->type == 'audio' ? 'selected' : '' }}>Audio</option>
                                                <option value="document" {{ $file->type == 'document' ? 'selected' : '' }}>Document</option>
                                                <option value="other" {{ $file->type == 'other' ? 'selected' : '' }}>Other</option>
                                            </select>
                                        </div> --}}
                    
                                        <div class="form-group">
                                            <label for="fileUpload{{ $file->id }}">Replace File (Optional)</label>
                                            <input type="file" name="file" id="fileUpload{{ $file->id }}" class="form-control-file">
                                        </div>
                                    </div>
                    
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                        <button type="submit" class="btn btn-primary">Save Changes</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="shareFileModal{{ $file->id }}" tabindex="-1" 
                        aria-labelledby="shareFileModalLabel{{ $file->id }}" aria-hidden="true">
                       <div class="modal-dialog">
                           <div class="modal-content">
                               <div class="modal-header bg-primary text-white">
                                   <h5 class="modal-title" id="shareFileModalLabel{{ $file->id }}">
                                       <i class="fas fa-share-alt"></i> Share File: {{ $file->name }}
                                   </h5>
                                   <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                       <span aria-hidden="true">&times;</span>
                                   </button>
                               </div>
                               <div class="modal-body">
                                   <form id="shareFileForm{{ $file->id }}">
                                       @csrf
                                       <input type="hidden" name="file_id" value="{{ $file->id }}">
                                       
                                       <label for="emailInput{{ $file->id }}" class="font-weight-bold">Enter Email:</label>
                                       <div class="input-group mb-3">
                                           <input type="email" id="emailInput{{ $file->id }}" name="email" 
                                                  class="form-control" placeholder="example@email.com" required>
                                           <div class="input-group-append">
                                               <button type="submit" class="btn btn-success">
                                                   <i class="fas fa-user-plus"></i> Add
                                               </button>
                                           </div>
                                       </div>
                                   </form>
                                   
                                   <hr>
                                   
                                   <h6 class="font-weight-bold">Users with Access:</h6>
                                   <ul id="sharedUsersList{{ $file->id }}" class="list-group">
                                       @foreach($file->sharedUsers as $user)
                                           <li class="list-group-item d-flex justify-content-between align-items-center">
                                               <span>
                                                   <i class="fas fa-user"></i> {{ $user->email }}
                                               </span>
                                               <button class="btn btn-danger btn-sm remove-access-btn" 
                                                       data-file-id="{{ $file->id }}" 
                                                       data-user-id="{{ $user->id }}">
                                                   <i class="fas fa-trash-alt"></i> Remove
                                               </button>
                                           </li>
                                       @endforeach
                                   </ul>
                                   
                                   <hr>
                                   <div class="text-center">
                                       <button class="btn btn-info copy-link-btn" data-link="{{ route('files.show', $file->id) }}">
                                           <i class="fas fa-copy"></i> Copy Share Link
                                       </button>
                                   </div>
                               </div>
                           </div>
                       </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.copy-link-btn').forEach(button => {
                button.addEventListener('click', function () {
                    let link = this.getAttribute('data-link');
                    navigator.clipboard.writeText(link).then(() => {
                        alert('Link copied to clipboard!');
                    }).catch(err => {
                        console.error('Failed to copy: ', err);
                    });
                });
            });
        });
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('[id^="shareFileForm"]').forEach(form => {
                form.addEventListener('submit', function (event) {
                    event.preventDefault();
                    
                    let formData = new FormData(this);
                    let fileId = this.querySelector('input[name="file_id"]').value;
                    let emailInput = this.querySelector('input[name="email"]');
        
                    fetch("{{ route('files.share') }}", {
                        method: "POST",
                        headers: {
                            "X-CSRF-TOKEN": "{{ csrf_token() }}",
                        },
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            let userList = document.getElementById('sharedUsersList' + fileId);
                            let newUserItem = document.createElement('li');
                            newUserItem.className = "list-group-item d-flex justify-content-between align-items-center";
                            newUserItem.innerHTML = `
                                ${data.email}
                                <button class="btn btn-danger btn-sm remove-access-btn" data-file-id="${fileId}" data-user-id="${data.user_id}">Remove</button>
                            `;
                            userList.appendChild(newUserItem);
                            emailInput.value = "";
                        } else {
                            alert("Error: " + data.message);
                        }
                    })
                    .catch(error => console.error("Error:", error));
                });
            });
        
            document.addEventListener('click', function (event) {
                if (event.target.classList.contains('remove-access-btn')) {
                    let fileId = event.target.getAttribute('data-file-id');
                    let userId = event.target.getAttribute('data-user-id');
        
                    fetch("{{ route('files.remove_access') }}", {
                        method: "POST",
                        headers: {
                            "X-CSRF-TOKEN": "{{ csrf_token() }}",
                            "Content-Type": "application/json"
                        },
                        body: JSON.stringify({ file_id: fileId, user_id: userId })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            event.target.parentElement.remove();
                        } else {
                            alert("Error: " + data.message);
                        }
                    })
                    .catch(error => console.error("Error:", error));
                }
            });
        });
    </script>
    

@endsection
