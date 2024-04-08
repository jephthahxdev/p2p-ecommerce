// Get the modal
var modal = document.getElementById('messageModal');

// Get the <span> element that closes the modal
var span = document.getElementsByClassName('close')[0];

// Function to show the modal with message
function showMessage(message) {
    var messageText = document.getElementById('messageText');
    messageText.innerHTML = message;
    modal.style.display = 'block';
}

// Function to hide the modal
function hideModal() {
    modal.style.display = 'none';
}

// Close the modal when the user clicks on <span> (x)
span.onclick = hideModal;

// For toggle menu
function toggleCanvas() {
    const canvas = document.getElementById('canvas');
    const toggleBtn = document.getElementById('toggleBtn');

    canvas.style.display = (canvas.style.display === 'none' || canvas.style.display === '') ? 'block' : 'none';

    // Toggle active class for icon change
    toggleBtn.classList.toggle('active');
}

//For image field
document.getElementById('images').addEventListener('change', function(event) {
    const previewDiv = document.querySelector('.image-preview');
    previewDiv.innerHTML = '';

    const files = event.target.files;
    for (const file of files) {
        const reader = new FileReader();

        reader.onload = function() {
            const img = new Image();
            img.src = reader.result;
            previewDiv.appendChild(img);
        }

        reader.readAsDataURL(file);
    }
});
