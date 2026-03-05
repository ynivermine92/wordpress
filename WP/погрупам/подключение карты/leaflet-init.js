document.addEventListener('DOMContentLoaded', function () {
    var map = L.map('map').setView([48.8566, 2.3522], 13);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);


    var points = [
        [48.8566, 2.3522],  
        [48.8606, 2.3376],  
        [48.8530, 2.3499]  
    ];


    points.forEach(function (coord, i) {
        L.marker(coord).addTo(map)
            .bindPopup('Точка #' + (i + 1));
    });

 
    var polyline = L.polyline(points, {
        color: 'blue',
        weight: 4,
        opacity: 0.7,
        dashArray: '10,10',
        lineJoin: 'round'
    }).addTo(map);


    map.fitBounds(polyline.getBounds());
});
