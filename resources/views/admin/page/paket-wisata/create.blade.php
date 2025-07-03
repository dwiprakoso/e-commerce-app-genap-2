@extends('admin.layouts.app')
@section('content')
    <!-- Main Content -->
    <div id="content">

        <!-- Begin Page Content -->
        <div class="container-fluid">

            <!-- Page Heading -->
            <h1 class="h3 mb-4 text-gray-800">Tambah Paket Wisata</h1>

            <!-- Form Card -->
            <div class="card shadow mb-4">
                <div class="card-body">
                    <form action="{{ route('admin.paket-wisata.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group">
                            <label for="title">Judul Paket <span class="text-danger">*</span></label>
                            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                                id="title" placeholder="Masukkan judul paket wisata..." required
                                value="{{ old('title') }}">
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="description">Deskripsi <span class="text-danger">*</span></label>
                            <textarea name="description" class="form-control @error('description') is-invalid @enderror" id="description"
                                rows="5" placeholder="Masukkan deskripsi paket wisata..." required>{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="image">Gambar Paket <span class="text-danger">*</span></label>
                            <input type="file" name="image"
                                class="form-control-file @error('image') is-invalid @enderror" id="image"
                                accept="image/jpeg,image/png,image/jpg,image/gif,image/webp" required>
                            <small class="form-text text-muted">
                                <strong>Persyaratan gambar:</strong><br>
                                • Format: JPEG, PNG, JPG, GIF, WebP<br>
                                • Ukuran maksimal: 2MB<br>
                                • Resolusi minimal: 800x600 pixel<br>
                                • Resolusi maksimal: 4000x4000 pixel
                            </small>
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div id="imageError" class="text-danger mt-2" style="display: none;"></div>
                        </div>

                        <div class="form-group">
                            <label for="price">Harga (Rp) <span class="text-danger">*</span></label>
                            <input type="text" name="price" class="form-control @error('price') is-invalid @enderror"
                                id="price" placeholder="Masukkan harga paket..." required
                                value="{{ old('price', isset($paketwisata) ? $paketwisata->price : '') }}"
                                pattern="[0-9,.]+" inputmode="numeric">
                            <small class="form-text text-muted">Masukkan harga dalam Rupiah (contoh: 800000 atau
                                800.000)</small>
                            @error('price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="start_date">Tanggal Mulai <span class="text-danger">*</span></label>
                                    <input type="date" name="start_date"
                                        class="form-control @error('start_date') is-invalid @enderror" id="start_date"
                                        required value="{{ old('start_date') }}">
                                    @error('start_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="end_date">Tanggal Berakhir <span class="text-danger">*</span></label>
                                    <input type="date" name="end_date"
                                        class="form-control @error('end_date') is-invalid @enderror" id="end_date" required
                                        value="{{ old('end_date') }}">
                                    @error('end_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="status">Status <span class="text-danger">*</span></label>
                            <select name="status" class="form-control @error('status') is-invalid @enderror" id="status"
                                required>
                                <option value="">Pilih Status</option>
                                <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                                <option value="publish" {{ old('status') == 'publish' ? 'selected' : '' }}>Publish</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Preview Image -->
                        <div class="form-group" id="imagePreview" style="display: none;">
                            <label>Preview Gambar:</label>
                            <div>
                                <img id="preview" src="#" alt="Preview" class="img-thumbnail"
                                    style="max-width: 300px;">
                            </div>
                            <div id="imageInfo" class="mt-2">
                                <small class="text-muted">
                                    <span id="fileName"></span><br>
                                    <span id="fileSize"></span><br>
                                    <span id="fileDimensions"></span>
                                </small>
                            </div>
                        </div>

                        <div class="form-group">
                            <a href="{{ route('admin.paket-wisata.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-primary" id="submitBtn">
                                <i class="fas fa-save"></i> Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- End of Main Content -->
    <script>
        // Configuration for image validation
        const imageConfig = {
            maxSize: 2 * 1024 * 1024, // 2MB in bytes
            allowedTypes: ['image/jpeg', 'image/png', 'image/jpg', 'image/gif', 'image/webp'],
            minWidth: 800,
            minHeight: 600,
            maxWidth: 4000,
            maxHeight: 4000
        };

        // Function to format file size
        function formatFileSize(bytes) {
            if (bytes === 0) return '0 Bytes';
            const k = 1024;
            const sizes = ['Bytes', 'KB', 'MB', 'GB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
        }

        // Function to validate image
        function validateImage(file) {
            return new Promise((resolve, reject) => {
                // Check file type
                if (!imageConfig.allowedTypes.includes(file.type)) {
                    reject('Format file tidak didukung. Hanya diperbolehkan: JPEG, PNG, JPG, GIF, WebP');
                    return;
                }

                // Check file size
                if (file.size > imageConfig.maxSize) {
                    reject(`Ukuran file terlalu besar. Maksimal ${formatFileSize(imageConfig.maxSize)}`);
                    return;
                }

                // Check file is not corrupted and get dimensions
                const img = new Image();
                const url = URL.createObjectURL(file);

                img.onload = function() {
                    URL.revokeObjectURL(url);

                    // Check dimensions
                    if (this.width < imageConfig.minWidth || this.height < imageConfig.minHeight) {
                        reject(
                            `Resolusi gambar terlalu kecil. Minimal ${imageConfig.minWidth}x${imageConfig.minHeight} pixel`);
                        return;
                    }

                    if (this.width > imageConfig.maxWidth || this.height > imageConfig.maxHeight) {
                        reject(
                            `Resolusi gambar terlalu besar. Maksimal ${imageConfig.maxWidth}x${imageConfig.maxHeight} pixel`);
                        return;
                    }

                    // All validations passed
                    resolve({
                        width: this.width,
                        height: this.height,
                        size: file.size,
                        name: file.name,
                        type: file.type
                    });
                };

                img.onerror = function() {
                    URL.revokeObjectURL(url);
                    reject('File gambar corrupt atau tidak valid');
                };

                img.src = url;
            });
        }

        // Function to show error message
        function showImageError(message) {
            const errorDiv = document.getElementById('imageError');
            errorDiv.textContent = message;
            errorDiv.style.display = 'block';

            // Add is-invalid class to input
            document.getElementById('image').classList.add('is-invalid');

            // Hide preview
            document.getElementById('imagePreview').style.display = 'none';

            // Disable submit button
            document.getElementById('submitBtn').disabled = true;
        }

        // Function to clear error message
        function clearImageError() {
            const errorDiv = document.getElementById('imageError');
            errorDiv.style.display = 'none';

            // Remove is-invalid class from input
            document.getElementById('image').classList.remove('is-invalid');

            // Enable submit button
            document.getElementById('submitBtn').disabled = false;
        }

        // Function to show image preview and info
        function showImagePreview(file, imageInfo) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('preview').src = e.target.result;
                document.getElementById('fileName').textContent = `Nama: ${imageInfo.name}`;
                document.getElementById('fileSize').textContent = `Ukuran: ${formatFileSize(imageInfo.size)}`;
                document.getElementById('fileDimensions').textContent =
                    `Dimensi: ${imageInfo.width}x${imageInfo.height} pixel`;
                document.getElementById('imagePreview').style.display = 'block';
            };
            reader.readAsDataURL(file);
        }

        // Image upload validation
        document.getElementById('image').addEventListener('change', function(e) {
            const file = e.target.files[0];

            if (!file) {
                document.getElementById('imagePreview').style.display = 'none';
                clearImageError();
                return;
            }

            // Show loading state
            document.getElementById('submitBtn').disabled = true;

            // Validate image
            validateImage(file)
                .then(imageInfo => {
                    clearImageError();
                    showImagePreview(file, imageInfo);
                })
                .catch(error => {
                    showImageError(error);
                    // Clear the input
                    e.target.value = '';
                });
        });

        // Set minimum date to today for start_date (hanya untuk create)
        document.getElementById('start_date').min = new Date().toISOString().split('T')[0];

        // Update end_date minimum when start_date changes
        document.getElementById('start_date').addEventListener('change', function() {
            const startDate = this.value;
            const endDateInput = document.getElementById('end_date');
            endDateInput.min = startDate;

            // Clear end_date if it's before the new start_date
            if (endDateInput.value && endDateInput.value <= startDate) {
                endDateInput.value = '';
            }
        });

        // Set initial min for end_date (untuk edit)
        const currentStartDate = document.getElementById('start_date').value;
        if (currentStartDate) {
            document.getElementById('end_date').min = currentStartDate;
        }

        // Price input handling
        const priceInput = document.getElementById('price');
        let isFormatting = false;

        // Format price display with thousand separators
        function formatPrice(value) {
            // Remove all non-digits
            const numericValue = value.toString().replace(/\D/g, '');
            if (numericValue === '') return '';
            return parseInt(numericValue).toLocaleString('id-ID');
        }

        // Handle input event
        priceInput.addEventListener('input', function(e) {
            if (isFormatting) return;

            isFormatting = true;
            const cursorPosition = e.target.selectionStart;
            const oldValue = e.target.value;
            const numericValue = oldValue.replace(/\D/g, '');

            if (numericValue) {
                const formattedValue = formatPrice(numericValue);
                e.target.value = formattedValue;

                // Restore cursor position
                const newCursorPosition = cursorPosition + (formattedValue.length - oldValue.length);
                setTimeout(() => {
                    e.target.setSelectionRange(newCursorPosition, newCursorPosition);
                }, 0);
            }

            isFormatting = false;
        });

        // Handle focus - remove formatting for easier editing
        priceInput.addEventListener('focus', function(e) {
            const numericValue = e.target.value.replace(/\D/g, '');
            e.target.value = numericValue;
        });

        // Handle blur - add formatting back
        priceInput.addEventListener('blur', function(e) {
            if (e.target.value) {
                e.target.value = formatPrice(e.target.value);
            }
        });

        // Form submission validation
        document.querySelector('form').addEventListener('submit', function(e) {
            // Check if image validation passed
            if (document.getElementById('imageError').style.display === 'block') {
                e.preventDefault();
                alert('Mohon perbaiki error pada gambar sebelum submit form');
                return false;
            }

            // Remove price formatting before submission
            const priceInput = document.getElementById('price');
            const numericValue = priceInput.value.replace(/\D/g, '');
            priceInput.value = numericValue;
        });

        // Format initial price value on page load (untuk edit)
        window.addEventListener('load', function() {
            const priceInput = document.getElementById('price');
            if (priceInput.value && !priceInput.value.includes('.')) {
                priceInput.value = formatPrice(priceInput.value);
            }
        });
    </script>
@endsection
