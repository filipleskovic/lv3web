function openWeatherDetailPage(item) {
            const detailWindow = window.open('', '_blank');
            const backgroundColor = getBackgroundColor(item.temperature);
            
            // Setting the background color based on temperature
            detailWindow.document.write(`
                <html>
                    <head>
                        <title>Detalji o vremenu</title>
                        <style>
                            body {
                                background-color: ${backgroundColor};
                                font-family: Arial, sans-serif;
                                padding: 20px;
                            }
                            .card {
                                background-color: white;
                                padding: 20px;
                                border-radius: 10px;
                                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                                width: 80%;
                                margin: 0 auto;
                            }
                            h2 {
                                text-align: center;
                                color: #333;
                            }
                            p {
                                font-size: 18px;
                                margin: 10px 0;
                            }
                        </style>
                    </head>
                    <body>
                        <div class="card">
                            <h2>Detalji o vremenskoj prognozi</h2>
                            <p><strong>ID:</strong> ${item.id}</p>
                            <p><strong>Temperature (°C):</strong> ${item.temperature}</p>
                            <p><strong>Humidity (%):</strong> ${item.humidity}</p>
                            <p><strong>Wind Speed (km/h):</strong> ${item.wind_speed}</p>
                            <p><strong>Season:</strong> ${item.season}</p>
                            <p><strong>Location:</strong> ${item.location}</p>
                            <p><strong>Weather Type:</strong> ${item.weather_type}</p>
                        </div>
                    </body>
                </html>
            `);
        }

        function getBackgroundColor(temperature) {
            if (temperature > 30) {
                return 'lightcoral'; 
            } else if (temperature >= 15) {
                return 'lightgreen';
            } else {
                return 'lightblue'; 
            }
        }

        window.onload = fetchWeatherData;