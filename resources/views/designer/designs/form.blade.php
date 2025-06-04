<div class="bg-white rounded-lg shadow-md p-8">
    <div class="mb-8">
        <h2 class="text-2xl font-heading font-semibold text-navy mb-1">
            {{ isset($design) ? 'Edit Design: ' . $design->title : 'Create New Design' }}
        </h2>
        <p class="text-charcoal/70">{{ isset($design) ? 'Update your design information and preview image.' : 'Add a new wallpaper design to your collection.' }}</p>
    </div>

    <form action="{{ isset($design) ? route('designer.designs.update', $design) : route('designer.designs.store') }}" 
          method="POST" 
          enctype="multipart/form-data"
          class="space-y-8">
        @csrf
        @if(isset($design))
            @method('PUT')
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Left column - Design details -->
            <div class="space-y-6">
                <!-- Title -->
                <div>
                    <label for="title" class="block text-sm font-medium text-navy mb-1">Title <span class="text-red-500">*</span></label>
                    <input type="text" 
                           name="title" 
                           id="title" 
                           value="{{ old('title', $design->title ?? '') }}" 
                           class="w-full px-3 py-2 border border-charcoal/20 rounded-md focus:outline-none focus:ring-2 focus:ring-gold/50 focus:border-gold/50 transition-colors"
                           required>
                    @error('title')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="block text-sm font-medium text-navy mb-1">Description</label>
                    <textarea name="description" 
                              id="description" 
                              rows="4" 
                              class="w-full px-3 py-2 border border-charcoal/20 rounded-md focus:outline-none focus:ring-2 focus:ring-gold/50 focus:border-gold/50 transition-colors">{{ old('description', $design->description ?? '') }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Category -->
                <div>
                    <label for="category_id" class="block text-sm font-medium text-navy mb-1">Category <span class="text-red-500">*</span></label>
                    <select name="category_id" 
                            id="category_id" 
                            class="w-full px-3 py-2 border border-charcoal/20 rounded-md focus:outline-none focus:ring-2 focus:ring-gold/50 focus:border-gold/50 transition-colors"
                            required>
                        <option value="">Select a category</option>
                        @foreach($categories ?? [] as $category)
                            <option value="{{ $category->id }}" {{ old('category_id', $design->category_id ?? '') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tags -->
                <div>
                    <label for="tags" class="block text-sm font-medium text-navy mb-1">Tags</label>
                    <input type="text" 
                           name="tags" 
                           id="tags" 
                           value="{{ old('tags', isset($design) && $design->tags ? $design->tags->pluck('name')->implode(', ') : '') }}" 
                           placeholder="Classic, Floral, Minimalist (comma separated)"
                           class="w-full px-3 py-2 border border-charcoal/20 rounded-md focus:outline-none focus:ring-2 focus:ring-gold/50 focus:border-gold/50 transition-colors">
                    <p class="mt-1 text-xs text-charcoal/60">Separate tags with commas</p>
                    @error('tags')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Featured Checkbox -->
                <div class="flex items-center">
                    <input type="checkbox" 
                           name="is_featured" 
                           id="is_featured" 
                           value="1" 
                           {{ old('is_featured', $design->is_featured ?? false) ? 'checked' : '' }}
                           class="h-4 w-4 text-gold focus:ring-gold/50 border-charcoal/20 rounded transition-colors">
                    <label for="is_featured" class="ml-2 block text-sm text-navy">
                        Feature this design
                    </label>
                </div>
            </div>

            <!-- Right column - Image and recommended papers -->
            <div class="space-y-6">
                <!-- Design Image -->
                <div>
                    <label class="block text-sm font-medium text-navy mb-1">Design Image <span class="text-red-500">{{ isset($design) ? '' : '*' }}</span></label>
                    
                    @if(isset($design) && $design->image_path)
                        <div class="mb-4">
                            <p class="text-xs text-charcoal/60 mb-2">Current Image:</p>
                            <img src="{{ asset('storage/' . $design->image_path) }}" alt="{{ $design->title }}" class="w-full h-64 object-cover rounded-md">
                        </div>
                    @endif
                    
                    <div class="mt-2 flex justify-center px-6 pt-5 pb-6 border-2 border-charcoal/20 border-dashed rounded-md">
                        <div class="space-y-1 text-center">
                            <svg class="mx-auto h-12 w-12 text-charcoal/40" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <div class="flex text-sm text-charcoal/60">
                                <label for="image" class="relative cursor-pointer bg-ivory rounded-md font-medium text-navy hover:text-gold focus-within:outline-none focus-within:ring-2 focus-within:ring-gold/50 focus-within:ring-offset-2">
                                    <span class="px-2">Upload a file</span>
                                    <input id="image" name="image" type="file" accept="image/*" class="sr-only" {{ isset($design) ? '' : 'required' }}>
                                </label>
                                <p class="pl-1">or drag and drop</p>
                            </div>
                            <p class="text-xs text-charcoal/60">PNG, JPG, GIF up to 5MB</p>
                        </div>
                    </div>
                    @error('image')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Recommended Papers -->
                <div>
                    <label class="block text-sm font-medium text-navy mb-1">Recommended Papers</label>
                    <p class="text-xs text-charcoal/60 mb-3">Select papers that work well with this design</p>
                    
                    <div class="grid grid-cols-2 gap-4 max-h-64 overflow-y-auto pr-2">
                        @foreach($papers ?? [] as $paper)
                            <div class="relative flex items-start">
                                <div class="flex items-center h-5">
                                    <input id="paper_{{ $paper->id }}" 
                                           name="papers[]" 
                                           type="checkbox" 
                                           value="{{ $paper->id }}" 
                                           {{ (isset($design) && $design->papers->contains($paper->id)) || (is_array(old('papers')) && in_array($paper->id, old('papers', []))) ? 'checked' : '' }}
                                           class="h-4 w-4 text-gold focus:ring-gold/50 border-charcoal/20 rounded transition-colors">
                                </div>
                                <div class="ml-3 text-sm">
                                    <label for="paper_{{ $paper->id }}" class="font-medium text-navy">{{ $paper->name }}</label>
                                    <p class="text-charcoal/60">{{ $paper->size }} - {{ $paper->thickness_with_unit }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    @error('papers')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <div class="pt-5 border-t border-charcoal/10">
            <div class="flex justify-end space-x-3">
                <a href="{{ route('designer.designs.index') }}" class="inline-flex justify-center py-2 px-4 border border-charcoal/20 text-sm font-medium rounded-md text-charcoal bg-white hover:bg-ivory focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-navy/50 transition-colors">
                    Cancel
                </a>
                <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-navy bg-gold hover:bg-gold/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gold transition-colors">
                    {{ isset($design) ? 'Update Design' : 'Create Design' }}
                </button>
            </div>
        </div>
    </form>
</div> 