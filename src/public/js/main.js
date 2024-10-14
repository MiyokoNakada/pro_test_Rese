
//drawer menu
const target = document.getElementById("menu");
target.addEventListener("click", () => {
    target.classList.toggle("open");
    const nav = document.getElementById("nav");
    nav.classList.toggle("in");

    if (nav.classList.contains("in")) {
        target.classList.add("fixed");
    } else {
        target.classList.remove("fixed");
    }
});


//search function
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.search__option').forEach(function(element) {
        element.addEventListener('change', function() {
            document.querySelector('.search__form').submit();
        });
    });
});


//favourite function
document.addEventListener('DOMContentLoaded', function() {
    const favouriteButtons = document.querySelectorAll('.shops-cards__favourite');

    favouriteButtons.forEach(button => {
        button.addEventListener('click', function() {
            const userId = this.dataset.userId;
            const shopId = this.dataset.shopId;
            const isFavourited = this.classList.contains('favourited');

            const url = isFavourited ? '/unfavourite' : '/favourite';

            fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    user_id: userId,
                    shop_id: shopId
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    this.classList.toggle('favourited');
                }
            })
            .catch(error => console.error('Error:', error));
        });
    });
});



//booking confirmation
document.addEventListener('DOMContentLoaded', () => {
    const dateInput = document.querySelector('.booking-date');
    const timeInput = document.querySelector('.booking-time');
    const numberInput = document.querySelector('.booking-number');

    const displayDate = document.getElementById('display-date');
    const displayTime = document.getElementById('display-time');
    const displayNumber = document.getElementById('display-number');

    dateInput.addEventListener('input', () => {
        displayDate.textContent = dateInput.value || '0000-00-00';
    });
-
    timeInput.addEventListener('input', () => {
        displayTime.textContent = timeInput.value || '00:00';
    });

    numberInput.addEventListener('input', () => {
        displayNumber.textContent = numberInput.value || '0人';
    });
});


//count input(rating)
document.getElementById('comment').addEventListener('keyup', function() {
    const charCount = this.value.length;
    document.getElementById('charCount').textContent = charCount + " / 400";
});

//upload image file(rating)
document.addEventListener('DOMContentLoaded', function() {
    const dropArea = document.getElementById('dropArea');
    const uploadFile = document.getElementById('uploadFile');

    dropArea.addEventListener('click', function() {
        uploadFile.click();
    });
    uploadFile.addEventListener('change', function() {
        const file = uploadFile.files[0];
        handleFile(file);
    });

    dropArea.addEventListener('dragover', function(e) {
        e.preventDefault();
        dropArea.classList.add('dragover');
    });
    dropArea.addEventListener('dragleave', function() {
        dropArea.classList.remove('dragover');
    });
    dropArea.addEventListener('drop', function(e) {
        e.preventDefault();
        dropArea.classList.remove('dragover');
        const files = e.dataTransfer.files;
        uploadFile.files = files;
        const file = files[0];
        handleFile(file);
    });
});
function handleFile(file) {
    const selectedFileName = document.getElementById('selectedFileName');
    const fileNameDisplay = document.getElementById('fileName');

    if (file) {
        selectedFileName.textContent = file.name;
        fileNameDisplay.style.display = 'block';
        console.log('ファイルが選択されました:', file.name);
    } else {
        fileNameDisplay.style.display = 'none';
    }
}