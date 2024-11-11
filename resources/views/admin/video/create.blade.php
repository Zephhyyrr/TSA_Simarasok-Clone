@extends('admin.layout.main')

@section('header')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Video Baru</h1>
</div>
@endsection

@section('content')
    <div class="col-6">
        <a href="/admin/video" class="btn btn-sm btn-warning mb-3">Kembali</a>
        <form action="/admin/video" method="post" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label class="form-label">Judul video</label>
                <input type="text" class="form-control @error('title') is-invalid @enderror" name="title"
                    value="{{ old('title') }}" placeholder="Masukkan judul video">
                @error('title')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label" for="youtube-link">URL</label>
                <div id="preview-youtube"></div>
                <input type="text" id="youtube-link" class="form-control" placeholder="Masukkan link YouTube" value="{{ old('url') }}" name="url">
                @error('url')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
                <script>
                    const urlContainer = document.getElementById('youtube-link');
                    const previewContainer = document.getElementById('preview-youtube');
                    urlContainer.addEventListener('input', () => {
                        previewContainer.innerHTML = '';
                        const link = urlContainer.value;
                        const videoId = link.split('v=')[1] || link.split('/').pop();

                        const previewWrapper = document.createElement('div');
                        previewWrapper.style.position = 'relative';
                        previewWrapper.style.display = 'inline-block';

                        const iframe = document.createElement('iframe');
                        iframe.width = '300';
                        iframe.height = '150';
                        iframe.src = `https://www.youtube.com/embed/${videoId}`;
                        iframe.frameBorder = '0';
                        iframe.allow = 'accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture';
                        iframe.allowFullscreen = true;

                        const removeButton = document.createElement('button');
                        removeButton.innerHTML = '&#x2715;';
                        removeButton.style.position = 'absolute';
                        removeButton.style.top = '5px';
                        removeButton.style.right = '5px';
                        removeButton.style.backgroundColor = 'rgba(255, 0, 0, 0.5)';
                        removeButton.style.border = 'none';
                        removeButton.style.borderRadius = '50%';
                        removeButton.style.cursor = 'pointer';
                        removeButton.style.width = '26px';
                        removeButton.style.height = '26px';
                        removeButton.addEventListener('click', () => {
                            previewWrapper.remove();
                            urlContainer.value = '';
                        });

                        previewWrapper.appendChild(iframe);
                        previewWrapper.appendChild(removeButton);
                        previewContainer.appendChild(previewWrapper);
                    });
                </script>
            </div>

            <button class="btn btn-sm btn-primary" type="submit">Submit</button>
            <div style="height: 25vh"></div>
        </form>
    </div>
@endsection
