document.getElementById('primijeni-filtere').addEventListener('click', () => {
    const selectedSeason = document.getElementById('filter-genre').value;
    const temperatureInput = document.getElementById('filter-temperature').value;
    const selectedLocation = document.querySelector('input[name="location"]:checked');
    const locationValue = selectedLocation ? selectedLocation.value : "";

    const url = new URL('filterWeather.php', window.location.origin);
    const params = new URLSearchParams();

    if (selectedSeason) params.append('season', selectedSeason);
    if (temperatureInput) params.append('min_temperature', temperatureInput);
    if (locationValue) params.append('location', locationValue);

    url.search = params.toString();

    fetch(url)
        .then(response => response.json())
        .then(data => {
            prikaziTablicu(data, '#vrijeme-tablica2 tbody');
        })
        .catch(error => {
            console.error('Greška pri dohvaćanju podataka:', error);
        });
});

function prikaziTablicu(data, id) {
    const tbody = document.querySelector(id);
    tbody.innerHTML = '';
    data.forEach(item => {
        const row = document.createElement('tr');
        row.innerHTML = `
            <td>${item.id}</td>
            <td>${item.temperature}</td>
            <td>${item.humidity}</td>
            <td>${item.wind_speed}</td>
            <td>${item.season}</td>
            <td>${item.location}</td>
            <td>${item.weather_type}</td>
        `;
        tbody.appendChild(row);
    });
}
