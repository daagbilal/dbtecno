function del_eval(product_id) {
    const url = "/libs/del_evaluation.php?product_id=" + product_id;
    const options = {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
        },
    };
    fetch(url, options)
        .then(response => response.json())
        .then(data => {
            const mesaj = data.mesaj;
            alert(mesaj);
            window.location.reload();
        })
        .catch(error => {
            console.log("Hata:", error);
        });
}
function sepetekle(urun_id) {
    const url = "/libs/sepete_ekle.php?product_id=" + urun_id;
    const options = {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
        },
    };
    fetch(url, options)
        .then(response => response.json())
        .then(data => {
            const mesaj = data.mesaj;
            alert(mesaj);
        })
        .catch(error => {
            console.log("Hata:", error);
        });
}

function favorite_product(durum, urun_id) {
    let url = "";
    if (durum == 1) {
        url = "/libs/rm_favorite.php?product_id=" + urun_id;
    } else if (durum == 0) {
        url = "/libs/add_favorite.php?product_id=" + urun_id;
    }
    const options = {
        method: 'GET',
    }
    fetch(url, options)
        .then(response => response.json())
        .then(data => {
            const mesaj = data.mesaj;
            if (mesaj == 1) {
                window.location.reload();
            }
        })
        .catch(error => {
            console.error("Hata:", error);
        });
}
function delete_product(urun_id) {
    const url = "/libs/urun_kaldir.php?product_id=" + urun_id;

    const options = {
        method: 'GET',
    };

    fetch(url, options)
        .then(response => response.json())
        .then(data => {
            const mesaj = data.mesaj;
            if (mesaj == 1) {
                window.location.reload();
            }
        })
        .catch(error => {
            console.error("Hata:", error);
        });
}