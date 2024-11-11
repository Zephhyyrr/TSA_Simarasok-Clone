let currentFiles = [];
let youtubeLinks = [];
const previewFiles = (event) => {
    const newFiles = Array.from(event.target.files);
    currentFiles = currentFiles.concat(newFiles);
    const previewContainer = document.getElementById("preview-container");
    previewContainer.innerHTML = "";
    currentFiles.forEach((file, index) => {
        const reader = new FileReader();
        reader.onload = () => {
            let mediaElement;
            const previewWrapper = document.createElement("div");
            previewWrapper.style.position = "relative";
            previewWrapper.style.display = "inline-block";
            if (file.type.startsWith("image/")) {
                mediaElement = document.createElement("img");
                mediaElement.src = reader.result;
            } else if (file.type.startsWith("video/")) {
                mediaElement = document.createElement("video");
                mediaElement.src = reader.result;
                mediaElement.controls = true;
            }
            if (mediaElement) {
                mediaElement.classList.add("img-thumbnail");
                mediaElement.style.width = "300px";
                mediaElement.style.display = "block";
                const removeButton = document.createElement("button");
                removeButton.innerHTML = "&#x2715;";
                removeButton.style.position = "absolute";
                removeButton.style.top = "5px";
                removeButton.style.right = "5px";
                removeButton.style.backgroundColor = "rgba(255, 0, 0, 0.5)";
                removeButton.style.width = "26px";
                removeButton.style.height = "26px";
                removeButton.style.border = "none";
                removeButton.style.borderRadius = "50%";
                removeButton.style.cursor = "pointer";
                removeButton.addEventListener("click", () => {
                    previewWrapper.remove();
                    currentFiles.splice(index, 1);
                    updateFileInput(currentFiles);
                });
                previewWrapper.appendChild(mediaElement);
                previewWrapper.appendChild(removeButton);
                previewContainer.appendChild(previewWrapper);
            }
        };
        reader.readAsDataURL(file);
    });
    updateFileInput(currentFiles);
};

const updateFileInput = (updatedFiles) => {
    const dataTransfer = new DataTransfer();
    updatedFiles.forEach((file) => dataTransfer.items.add(file));
    document.getElementById("gambar").files = dataTransfer.files;
};

const addYouTubeVideo = () => {
    const link = document.getElementById("youtube-link").value;
    const videoId = link.split("v=")[1] || link.split("/").pop();
    youtubeLinks.push(link);
    const previewContainer = document.getElementById("preview-youtube");
    const iframe = document.createElement("iframe");
    iframe.width = "300";
    iframe.height = "150";
    iframe.src = `https://www.youtube.com/embed/${videoId}`;
    iframe.frameBorder = "0";
    iframe.allow =
        "accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture";
    iframe.allowFullscreen = true;

    const previewWrapper = document.createElement("div");
    previewWrapper.style.position = "relative";
    previewWrapper.style.display = "inline-block";

    const removeButton = document.createElement("button");
    removeButton.innerHTML = "&#x2715;";
    removeButton.style.position = "absolute";
    removeButton.style.top = "5px";
    removeButton.style.right = "5px";
    removeButton.style.backgroundColor = "rgba(255, 0, 0, 0.5)";
    removeButton.style.width = "26px";
    removeButton.style.height = "26px";
    removeButton.style.border = "none";
    removeButton.style.borderRadius = "50%";
    removeButton.style.cursor = "pointer";
    removeButton.addEventListener("click", () => {
        previewWrapper.remove();
        const index = youtubeLinks.indexOf(link);
        if (index > -1) {
            youtubeLinks.splice(index, 1);
        }
    });

    previewWrapper.appendChild(iframe);
    previewWrapper.appendChild(removeButton);
    previewContainer.appendChild(previewWrapper);

    document.getElementById("youtube-links").value =
        JSON.stringify(youtubeLinks);
    document.getElementById("youtube-link").value = "";
};
