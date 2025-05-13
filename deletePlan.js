function deletePlan() {
    fetch("deletePlan.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" }
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