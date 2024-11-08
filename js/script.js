
let slideIndex = 0;
showSlides();

function showSlides() {
    const slides = document.getElementsByClassName("mySlides");
    for (let i = 0; i < slides.length; i++) {
        slides[i].style.display = "none";
    }
    slideIndex++;
    if (slideIndex > slides.length) { 
        slideIndex = 1; 
    }
    slides[slideIndex - 1].style.display = "block";
    setTimeout(showSlides, 5000); 
}

function plusSlides(n) {
    const slides = document.getElementsByClassName("mySlides");
    slides[slideIndex - 1].style.display = "none";
    slideIndex += n;
    if (slideIndex > slides.length) { 
        slideIndex = 1; 
    }
    if (slideIndex < 1) { 
        slideIndex = slides.length; 
    }
    slides[slideIndex - 1].style.display = "block";
}



document.getElementById('bookingForm').addEventListener('submit', function(event) {
    event.preventDefault();

    const name = document.getElementById('name').value;
    const email = document.getElementById('email').value;
    const date = document.getElementById('date').value;
    const time = document.getElementById('time').value;
    const service = document.getElementById('service').value;

    const bookingDate = new Date(date + ' ' + time);
    const dayOfWeek = bookingDate.getDay();
    const hours = bookingDate.getHours();

    let valid = false;

    if ((dayOfWeek >= 1 && dayOfWeek <= 5 && hours >= 8 && hours < 19) || 
        (dayOfWeek === 6 && hours >= 9 && hours < 14)) {
        valid = true;
    }

    if (valid && name && email && date && time && service) {
        alert(`Booking Confirmed!\nName: ${name}\nEmail: ${email}\nDate: ${date}\nTime: ${time}\nService: ${service}`);
    } else {
        alert('Please fill in all fields with valid data.');
    }
});


document.addEventListener('DOMContentLoaded', function() {
    const services = [
        { name: 'Nail Care', img: 'images/IMG-20240225-WA0072.png', description: 'Professional nail care services.' },
        { name: 'Hair Styling', img: 'images/IMG-20240225-WA0073.png', description: 'Trendy hair styling services.' },
        { name: 'Lash Additions', img: 'images/IMG-20240225-WA0082.png', description: 'Beautiful lash additions.' }
    ];

    const products = [
        { name: 'Bonnets', img: 'images/bonnet.png', description: 'High-quality hair bonnets.' },
        { name: 'Body Scrubs', img: 'images/scrub.png', description: 'Premium soothing body scrubs.' }
    ];

    function renderItems(items, containerId) {
        const container = document.getElementById(containerId);
        items.forEach(item => {
            const itemDiv = document.createElement('div');
            itemDiv.className = 'grid-item';
            itemDiv.innerHTML = `
                <img src="${item.img}" alt="${item.name}">
                <h3>${item.name}</h3>
                <p>${item.description}</p>
            `;
            container.appendChild(itemDiv);
        });
    }

    renderItems(services, 'services-list');
    renderItems(products, 'products-list');
});


window.onscroll = function() {
    scrollFunction();
};

function scrollFunction() {
    const upBtn = document.getElementById("upBtn");
    if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
        upBtn.style.display = "block";
    } else {
        upBtn.style.display = "none";
    }
}

function scrollToTop() {
    document.body.scrollTop = 0;
    document.documentElement.scrollTop = 0; 
}

function goBack() {
    window.history.back();
}