@extends('layouts.app')

@section('content')
<div class="bg-neutral min-h-screen py-12">
    <div class="container mx-auto px-4">
        <!-- Header -->
        <div class="text-center mb-12">
            <h1 class="font-serif text-4xl md:text-5xl text-charcoal font-bold mb-4">Create Your Custom Wallpaper</h1>
            <p class="text-charcoal/80 max-w-2xl mx-auto">Design your perfect wallpaper by choosing from our premium papers and beautiful designs, or upload your own artwork.</p>
        </div>

        <!-- Steps indicator -->
        <div class="max-w-5xl mx-auto mb-12">
            <div class="flex justify-between items-center">
                <div class="flex flex-col items-center">
                    <div class="w-12 h-12 rounded-full bg-gold flex items-center justify-center text-charcoal font-serif text-xl font-bold">1</div>
                    <span class="text-navy font-medium mt-2">Details</span>
                </div>
                <div class="flex-1 h-1 bg-gold/30 mx-2"></div>
                <div class="flex flex-col items-center">
                    <div class="w-12 h-12 rounded-full bg-gold flex items-center justify-center text-charcoal font-serif text-xl font-bold">2</div>
                    <span class="text-navy font-medium mt-2">Materials</span>
                </div>
                <div class="flex-1 h-1 bg-gold/30 mx-2"></div>
                <div class="flex flex-col items-center">
                    <div class="w-12 h-12 rounded-full bg-gold flex items-center justify-center text-charcoal font-serif text-xl font-bold">3</div>
                    <span class="text-navy font-medium mt-2">Submit</span>
                </div>
            </div>
        </div>

        <form action="{{ route('artworks.store') }}" method="POST" enctype="multipart/form-data" id="artworkForm">
            @csrf
            <div class="grid grid-cols-1 lg:grid-cols-5 gap-8 max-w-7xl mx-auto">
                <!-- Form Sections -->
                <div class="lg:col-span-3 space-y-8">
                    <!-- Section 1: Basic Details -->
                    <div class="bg-white rounded-xl shadow-subtle p-6 md:p-8">
                        <h2 class="font-serif text-2xl text-navy mb-6 pb-3 border-b border-neutral">1. Wallpaper Details</h2>
                        
                        <div class="space-y-6">
                            <div>
                                <label for="title" class="block text-charcoal font-medium mb-2">Title</label>
                                <input type="text" name="title" id="title" placeholder="e.g. Living Room Floral Pattern" class="form-input w-full rounded-lg border-gray-300 shadow-sm focus:border-gold focus:ring focus:ring-gold/20 transition @error('title') border-red-500 @enderror" value="{{ old('title') }}" required>
                                @error('title')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label for="description" class="block text-charcoal font-medium mb-2">Description</label>
                                <textarea name="description" id="description" rows="3" placeholder="Describe your wallpaper design..." class="form-textarea w-full rounded-lg border-gray-300 shadow-sm focus:border-gold focus:ring focus:ring-gold/20 transition @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
                                @error('description')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label for="width" class="block text-charcoal font-medium mb-2">Width (cm)</label>
                                    <input type="number" name="width" id="width" placeholder="Width" class="form-input w-full rounded-lg border-gray-300 shadow-sm focus:border-gold focus:ring focus:ring-gold/20 transition @error('width') border-red-500 @enderror" value="{{ old('width') }}" min="1">
                                    @error('width')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="height" class="block text-charcoal font-medium mb-2">Height (cm)</label>
                                    <input type="number" name="height" id="height" placeholder="Height" class="form-input w-full rounded-lg border-gray-300 shadow-sm focus:border-gold focus:ring focus:ring-gold/20 transition @error('height') border-red-500 @enderror" value="{{ old('height') }}" min="1">
                                    @error('height')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Section 2: Paper Selection -->
                    <div class="bg-white rounded-xl shadow-subtle p-6 md:p-8">
                        <h2 class="font-serif text-2xl text-navy mb-6 pb-3 border-b border-neutral">2. Select Your Paper</h2>
                        
                        <div class="grid grid-cols-2 gap-6">
                            @foreach($papers as $paper)
                                <div class="relative">
                                    <input type="radio" name="paper_id" id="paper_{{ $paper->id }}" value="{{ $paper->id }}" class="absolute opacity-0 w-0 h-0 peer" required>
                                    <label for="paper_{{ $paper->id }}" class="block p-4 bg-white border-2 rounded-lg cursor-pointer transition-all peer-checked:border-gold peer-checked:ring-2 peer-checked:ring-gold/50 shadow-sm hover:bg-neutral/10">
                                        <div class="aspect-video overflow-hidden rounded mb-3">
                                            <img src="{{ asset('storage/' . $paper->image_path) }}" alt="{{ $paper->name }}" class="w-full h-full object-cover">
                                        </div>
                                        <h4 class="font-serif text-navy text-lg">{{ $paper->name }}</h4>
                                        <p class="text-sm text-charcoal/70 mt-1">{{ $paper->size }}</p>
                                        <p class="text-sm text-charcoal/70">{{ $paper->thickness_with_unit }}</p>
                                        <div class="w-6 h-6 bg-gold rounded-full absolute top-3 right-3 flex items-center justify-center opacity-0 peer-checked:opacity-100 transition-opacity">
                                            <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                            </svg>
                                        </div>
                                    </label>
                                </div>
                            @endforeach
                        </div>
                        @error('paper_id')
                            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Section 3: Design Selection or Upload -->
                    <div class="bg-white rounded-xl shadow-subtle p-6 md:p-8">
                        <h2 class="font-serif text-2xl text-navy mb-6 pb-3 border-b border-neutral">3. Choose Your Design</h2>
                        
                        <div class="mb-6">
                            <div class="bg-neutral/10 rounded-lg p-4 mb-6">
                                <div class="flex items-center justify-between">
                                    <h3 class="font-medium text-charcoal">How would you like to proceed?</h3>
                                </div>
                                <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div>
                                        <label class="flex items-center p-4 border-2 border-gray-300 rounded-lg cursor-pointer transition hover:bg-neutral/5" id="select-design-option">
                                            <input type="radio" name="design_method" value="select" class="hidden" checked>
                                            <span class="w-5 h-5 rounded-full border-2 border-navy inline-block mr-3 flex-shrink-0 design-radio">
                                                <span class="w-3 h-3 rounded-full bg-navy block m-[3px]"></span>
                                            </span>
                                            <div>
                                                <span class="font-medium block">Select from our designs</span>
                                                <span class="text-sm text-charcoal/70">Choose from our curated collection</span>
                                            </div>
                                        </label>
                                    </div>
                                    <div>
                                        <label class="flex items-center p-4 border-2 border-gray-300 rounded-lg cursor-pointer transition hover:bg-neutral/5" id="upload-design-option">
                                            <input type="radio" name="design_method" value="upload" class="hidden">
                                            <span class="w-5 h-5 rounded-full border-2 border-navy inline-block mr-3 flex-shrink-0 design-radio">
                                                <span class="w-3 h-3 rounded-full bg-navy block m-[3px] opacity-0"></span>
                                            </span>
                                            <div>
                                                <span class="font-medium block">Upload your own design</span>
                                                <span class="text-sm text-charcoal/70">Use your custom artwork</span>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Option 1: Select from designs (default visible) -->
                        <div id="select-design-container">
                            <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                                @foreach($designs as $design)
                                    <div class="relative">
                                        <input type="radio" name="design_id" id="design_{{ $design->id }}" value="{{ $design->id }}" class="absolute opacity-0 w-0 h-0 peer">
                                        <label for="design_{{ $design->id }}" class="block p-3 bg-white border-2 rounded-lg cursor-pointer transition-all peer-checked:border-gold peer-checked:ring-2 peer-checked:ring-gold/50 shadow-sm hover:bg-neutral/10">
                                            <div class="aspect-square overflow-hidden rounded mb-2">
                                                <img src="{{ asset('storage/' . $design->image_path) }}" alt="{{ $design->title }}" class="w-full h-full object-cover">
                                            </div>
                                            <h4 class="font-medium text-navy truncate">{{ $design->title }}</h4>
                                            <p class="text-xs text-charcoal/70">By {{ $design->designer->name ?? 'Unknown Designer' }}</p>
                                            <div class="w-6 h-6 bg-gold rounded-full absolute top-2 right-2 flex items-center justify-center opacity-0 peer-checked:opacity-100 transition-opacity">
                                                <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                                </svg>
                                            </div>
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                            @error('design_id')
                                <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Option 2: Upload own design (initially hidden) -->
                        <div id="upload-design-container" class="hidden">
                            <div>
                                <label for="custom_design" class="block text-charcoal font-medium mb-2">Upload Your Design</label>
                                <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:bg-neutral/30 transition cursor-pointer" id="design-dropzone">
                                    <div class="space-y-1 text-center">
                                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                        <div class="flex text-sm text-gray-600">
                                            <label for="custom_design" class="relative cursor-pointer bg-white rounded-md font-medium text-gold hover:text-gold-light focus-within:outline-none">
                                                <span>Upload a file</span>
                                                <input id="custom_design" name="custom_design" type="file" class="sr-only" accept="image/*">
                                            </label>
                                            <p class="pl-1">or drag and drop</p>
                                        </div>
                                        <p class="text-xs text-gray-500">
                                            PNG, JPG, GIF up to 5MB
                                        </p>
                                    </div>
                                </div>
                                <div id="design-preview-container" class="mt-3 hidden">
                                    <img id="design-preview-image" src="#" alt="Preview" class="h-32 object-contain mx-auto rounded border border-gray-300">
                                    <button type="button" id="remove-design" class="mt-2 text-sm text-red-500 hover:text-red-700">Remove design</button>
                                </div>
                                @error('custom_design')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Section 4: Additional Image Upload (optional) -->
                    <div class="bg-white rounded-xl shadow-subtle p-6 md:p-8">
                        <h2 class="font-serif text-2xl text-navy mb-6 pb-3 border-b border-neutral">4. Additional Reference Image (Optional)</h2>
                        
                        <div>
                            <label for="image" class="block text-charcoal font-medium mb-2">Upload Reference Image</label>
                            <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:bg-neutral/30 transition cursor-pointer" id="dropzone">
                                <div class="space-y-1 text-center">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <div class="flex text-sm text-gray-600">
                                        <label for="image" class="relative cursor-pointer bg-white rounded-md font-medium text-gold hover:text-gold-light focus-within:outline-none">
                                            <span>Upload a file</span>
                                            <input id="image" name="image" type="file" class="sr-only" accept="image/*">
                                        </label>
                                        <p class="pl-1">or drag and drop</p>
                                    </div>
                                    <p class="text-xs text-gray-500">
                                        PNG, JPG, GIF up to 2MB
                                    </p>
                                </div>
                            </div>
                            <div id="preview-container" class="mt-3 hidden">
                                <img id="preview-image" src="#" alt="Preview" class="h-32 object-contain mx-auto rounded border border-gray-300">
                                <button type="button" id="remove-image" class="mt-2 text-sm text-red-500 hover:text-red-700">Remove image</button>
                            </div>
                            <p class="text-sm text-gray-500 mt-2">Optional: Upload any additional reference images to help our designers understand your vision.</p>
                            @error('image')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <!-- Order Summary Section -->
                <div class="lg:col-span-2 space-y-8">
                    <div class="bg-white rounded-xl shadow-subtle p-6 md:p-8 sticky top-6">
                        <h2 class="font-serif text-2xl text-navy mb-6 pb-3 border-b border-neutral">Order Summary</h2>
                        
                        <div class="bg-neutral/10 rounded-lg p-6 mb-6">
                            <div class="flex items-center space-x-3 mb-4 text-charcoal">
                                <svg class="w-8 h-8 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span class="font-medium">Preview Process</span>
                            </div>
                            <p class="text-charcoal/80 mb-3">After submission, our design team will:</p>
                            <ol class="space-y-2 text-sm text-charcoal/80 list-decimal list-inside mb-4">
                                <li>Review your specifications</li>
                                <li>Create a custom preview of your wallpaper</li>
                                <li>Send you a notification when your preview is ready</li>
                                <li>Allow you to approve or request changes</li>
                            </ol>
                            <div class="bg-gold/10 rounded p-3 border-l-4 border-gold">
                                <p class="text-sm text-charcoal/90">You'll be able to see and approve the final design before placing your order.</p>
                            </div>
                        </div>
                        
                        <div class="space-y-4">
                            <div class="bg-neutral/20 rounded-lg p-4 space-y-2">
                                <div class="flex justify-between text-sm">
                                    <span class="text-charcoal/70">Selected Paper:</span>
                                    <span class="font-medium text-navy" id="selected-paper">None selected</span>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-charcoal/70">Design:</span>
                                    <span class="font-medium text-navy" id="selected-design">None selected</span>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-charcoal/70">Dimensions:</span>
                                    <span class="font-medium text-navy" id="dimensions">Not specified</span>
                                </div>
                            </div>
                            
                            <div class="pt-4">
                                <div class="flex justify-between items-center">
                                    <a href="{{ route('artworks.index') }}" class="text-charcoal/70 hover:text-navy transition">
                                        Cancel
                                    </a>
                                    <button type="submit" class="bg-gold hover:bg-gold-light text-charcoal font-medium py-3 px-8 rounded-lg transition duration-300 flex items-center">
                                        Submit Request
                                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Reference image handling
        const imageInput = document.getElementById('image');
        const previewContainer = document.getElementById('preview-container');
        const previewImage = document.getElementById('preview-image');
        const removeButton = document.getElementById('remove-image');
        const dropzone = document.getElementById('dropzone');
        
        // Design method toggle
        const selectDesignOption = document.getElementById('select-design-option');
        const uploadDesignOption = document.getElementById('upload-design-option');
        const selectDesignContainer = document.getElementById('select-design-container');
        const uploadDesignContainer = document.getElementById('upload-design-container');
        const designRadios = document.querySelectorAll('.design-radio span');
        
        // Custom design upload
        const customDesignInput = document.getElementById('custom_design');
        const designDropzone = document.getElementById('design-dropzone');
        const designPreviewContainer = document.getElementById('design-preview-container');
        const designPreviewImage = document.getElementById('design-preview-image');
        const removeDesignButton = document.getElementById('remove-design');
        
        // Form elements
        const widthInput = document.getElementById('width');
        const heightInput = document.getElementById('height');
        const dimensionsDisplay = document.getElementById('dimensions');
        const paperInputs = document.querySelectorAll('input[name="paper_id"]');
        const designInputs = document.querySelectorAll('input[name="design_id"]');
        const selectedPaperDisplay = document.getElementById('selected-paper');
        const selectedDesignDisplay = document.getElementById('selected-design');
        
        // Toggle between design selection and upload
        selectDesignOption.addEventListener('click', function() {
            selectDesignContainer.classList.remove('hidden');
            uploadDesignContainer.classList.add('hidden');
            designRadios[0].classList.remove('opacity-0');
            designRadios[1].classList.add('opacity-0');
            
            // Make design_id required and custom_design not required
            designInputs.forEach(input => {
                input.setAttribute('required', '');
            });
            customDesignInput.removeAttribute('required');
            
            // Update selected design display
            const checkedDesign = document.querySelector('input[name="design_id"]:checked');
            if (checkedDesign) {
                const label = document.querySelector(`label[for="${checkedDesign.id}"]`);
                const designName = label.querySelector('h4').textContent;
                selectedDesignDisplay.textContent = designName;
            } else {
                selectedDesignDisplay.textContent = 'Choose from our collection';
            }
        });
        
        uploadDesignOption.addEventListener('click', function() {
            selectDesignContainer.classList.add('hidden');
            uploadDesignContainer.classList.remove('hidden');
            designRadios[0].classList.add('opacity-0');
            designRadios[1].classList.remove('opacity-0');
            
            // Make custom_design required and design_id not required
            customDesignInput.setAttribute('required', '');
            designInputs.forEach(input => {
                input.removeAttribute('required');
            });
            
            // Update selected design display
            selectedDesignDisplay.textContent = customDesignInput.files && customDesignInput.files[0] ? 
                'Custom design uploaded' : 'Upload your own design';
        });
        
        // Preview uploaded reference image
        imageInput.addEventListener('change', function() {
            if (this.files && this.files[0]) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    previewImage.src = e.target.result;
                    previewContainer.classList.remove('hidden');
                    dropzone.classList.add('border-gold', 'bg-gold/5');
                }
                
                reader.readAsDataURL(this.files[0]);
            }
        });
        
        // Remove preview reference image
        removeButton.addEventListener('click', function() {
            imageInput.value = '';
            previewContainer.classList.add('hidden');
            dropzone.classList.remove('border-gold', 'bg-gold/5');
        });
        
        // Preview uploaded custom design
        customDesignInput.addEventListener('change', function() {
            if (this.files && this.files[0]) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    designPreviewImage.src = e.target.result;
                    designPreviewContainer.classList.remove('hidden');
                    designDropzone.classList.add('border-gold', 'bg-gold/5');
                    selectedDesignDisplay.textContent = 'Custom design uploaded';
                }
                
                reader.readAsDataURL(this.files[0]);
            }
        });
        
        // Remove preview custom design
        removeDesignButton.addEventListener('click', function() {
            customDesignInput.value = '';
            designPreviewContainer.classList.add('hidden');
            designDropzone.classList.remove('border-gold', 'bg-gold/5');
            selectedDesignDisplay.textContent = 'Upload your own design';
        });
        
        // Update dimensions display when inputs change
        function updateDimensions() {
            const width = widthInput.value;
            const height = heightInput.value;
            
            if (width && height) {
                dimensionsDisplay.textContent = `${width} × ${height} cm`;
            } else {
                dimensionsDisplay.textContent = 'Not specified';
            }
        }
        
        widthInput.addEventListener('input', updateDimensions);
        heightInput.addEventListener('input', updateDimensions);
        
        // Update paper selection display
        paperInputs.forEach(input => {
            input.addEventListener('change', function() {
                if (this.checked) {
                    const label = document.querySelector(`label[for="${this.id}"]`);
                    const paperName = label.querySelector('h4').textContent;
                    selectedPaperDisplay.textContent = paperName;
                }
            });
        });
        
        // Update design selection display
        designInputs.forEach(input => {
            input.addEventListener('change', function() {
                if (this.checked) {
                    const label = document.querySelector(`label[for="${this.id}"]`);
                    const designName = label.querySelector('h4').textContent;
                    selectedDesignDisplay.textContent = designName;
                }
            });
        });
        
        // Drag and drop functionality for reference image
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            dropzone.addEventListener(eventName, preventDefaults, false);
        });
        
        // Drag and drop functionality for custom design
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            designDropzone.addEventListener(eventName, preventDefaults, false);
        });
        
        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }
        
        ['dragenter', 'dragover'].forEach(eventName => {
            dropzone.addEventListener(eventName, highlightDropzone, false);
            designDropzone.addEventListener(eventName, highlightDesignDropzone, false);
        });
        
        ['dragleave', 'drop'].forEach(eventName => {
            dropzone.addEventListener(eventName, unhighlightDropzone, false);
            designDropzone.addEventListener(eventName, unhighlightDesignDropzone, false);
        });
        
        function highlightDropzone() {
            dropzone.classList.add('border-gold', 'bg-gold/5');
        }
        
        function unhighlightDropzone() {
            dropzone.classList.remove('border-gold', 'bg-gold/5');
        }
        
        function highlightDesignDropzone() {
            designDropzone.classList.add('border-gold', 'bg-gold/5');
        }
        
        function unhighlightDesignDropzone() {
            designDropzone.classList.remove('border-gold', 'bg-gold/5');
        }
        
        dropzone.addEventListener('drop', handleDrop, false);
        designDropzone.addEventListener('drop', handleDesignDrop, false);
        
        function handleDrop(e) {
            const dt = e.dataTransfer;
            const files = dt.files;
            
            if (files && files.length) {
                imageInput.files = files;
                const event = new Event('change');
                imageInput.dispatchEvent(event);
            }
        }
        
        function handleDesignDrop(e) {
            const dt = e.dataTransfer;
            const files = dt.files;
            
            if (files && files.length) {
                customDesignInput.files = files;
                const event = new Event('change');
                customDesignInput.dispatchEvent(event);
            }
        }
    });
</script>
@endpush
@endsection 