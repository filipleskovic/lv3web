function deleteFromPlan(weather_id) {
    fetch("deleteFromPlan.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ weather_id })
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            fetchCartItems(); 
        } else {
            alert("Greška pri brisanju: " + (data.message || ""));
        }
    })
    .catch(err => {
        console.error("Greška:", err);
        alert("Došlo je do greške: " + err.message);
    });
}

    function fetchCartItems() {
        fetch('getPlanItems.php') 
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const cartList = document.getElementById("lista-kosarice");
                    cartList.innerHTML = ''; 

                    data.items.forEach(item => {
                        console.log(item)
                        const listItem = document.createElement('li');
                        listItem.textContent = `ID: ${item.weather_id}`;

                        const buttonX = document.createElement('button');
                        buttonX.textContent = 'X';
                        buttonX.classList.add('remove-btn');
                        buttonX.style.width = '40px';
                        buttonX.style.margin= '4px';
                        buttonX.addEventListener('click', () => {
                            deleteFromPlan(item.weather_id);
                        });

                         listItem.appendChild(buttonX);
                        cartList.appendChild(listItem);
                    });
                } else {
                    console.error('Greška pri dohvatu stavki iz košarice');
                }
            })
            .catch(error => console.error('Greška pri pozivu API-ja:', error));
    }
    function addToPlan() {
        const rows = document.querySelectorAll("#weather-table-body tr");
        const weatherIds = [];
    
        rows.forEach(row => {
            const idCell = row.querySelector("td");
            if (idCell) {
                weatherIds.push(idCell.textContent.trim());
            }
        });
        console.log(weatherIds)
        fetch("addToPlan.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify({ weatherIds })
        })
        .then(response => {
            if (!response.ok) throw new Error("HTTP greška " + response.status);
            return response.json();
        })
        .then(data => {
            if (data.success) {
                fetchCartItems(); 
            } else {
                alert("Greška pri dodavanju: " + (data.message || ""));
            }
        })
        .catch(error => {
            alert("Dogodila se greška: " + error.message);
        });
    }
    
    