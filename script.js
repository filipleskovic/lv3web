let sviFilmovi = [];

fetch('weather.csv')
    .then(res => res.text())
    .then(csv => {
        const results = Papa.parse(csv, { header: true, skipEmptyLines: true });
        sviFilmovi = results.data.map(day => ({
            id: day['ID'],
            temperature: Number(day['Temperature']),
            humidity: Number(day['Humidity']),
            wind_speed: Number(day['Wind Speed']),
            season: day.Season,
            location: day.Location,
            weather_type: day['Weather Type']
        }));

        const filtered = sviFilmovi.slice(0, 20);
        id1 = '#vrijeme-tablica tbody'
        id2 = '#vrijeme-tablica2 tbody'
        prikaziTablicu(filtered, id1);
        prikaziTablicu(filtered, id2);
    });

function prikaziTablicu(days, id) {
    const tbody = document.querySelector(id);
    tbody.innerHTML = '';
    for (const dan of days) {
        const row = document.createElement('tr');
        row.innerHTML = `<td>${dan.id}</td> 
                         <td>${dan.temperature}</td> 
                         <td>${dan.humidity}</td> 
                         <td>${dan.wind_speed}</td> 
                         <td>${dan.season}</td> 
                         <td>${dan.location}</td> 
                         <td>${dan.weather_type}</td>`;
        tbody.appendChild(row);
    }
}

document.getElementById('primijeni-filtere').addEventListener('click', () => {
    const selectedSeason = document.getElementById('filter-genre').value;
    const temperatureInput = document.getElementById('filter-temperature').value;

    const selectedLocation = document.querySelector('input[name="location"]:checked');
    const locationValue = selectedLocation ? selectedLocation.value : "";

    const filtrirani = sviFilmovi.filter(day => {
        const matchesSeason = selectedSeason === "" || day.season === selectedSeason;
        const matchesTemp = temperatureInput === "" || (day.temperature && Number(day.temperature) >= Number(temperatureInput));
        const matchesLocation = locationValue === "" || day.location === locationValue;

        return matchesSeason && matchesTemp && matchesLocation;
    });

    const sortirani = filtrirani.sort((a, b) => b.temperature - a.temperature);
    prikaziTablicu(sortirani, '#vrijeme-tablica2 tbody');
});
function addToCart(){
    const tablica2 = document.getElementById('vrijeme-tablica2').querySelector('tbody');
    const sviRedovi = tablica2.querySelectorAll('tr');
    const listaKosarice = document.getElementById('lista-kosarice');
    sviRedovi.forEach(red => {
        const prviTd = red.querySelector('td');
        if (prviTd) {
            const li = document.createElement('li');
            li.textContent = prviTd.textContent.trim() + ' ';

            const buttonX = document.createElement('button');
            buttonX.textContent = 'X';
            buttonX.classList.add('remove-btn');
            buttonX.style.width = '40px';
            buttonX.style.margin= '4px';
            buttonX.addEventListener('click', () => {
                li.remove();
            });

            li.appendChild(buttonX);
            listaKosarice.appendChild(li);
        }
    });
}
function obrisiSve() {
    document.getElementById('lista-kosarice').innerHTML = '';
}