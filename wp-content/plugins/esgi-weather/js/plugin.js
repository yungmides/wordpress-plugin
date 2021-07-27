console.log('TEST 1234');

document.addEventListener('DOMContentLoaded', async function () {
    const esgi_widget = document.getElementById('esgi-widget');
    const widget_root = esgi_widget.parentElement;
    const city = esgi_widget.getAttribute('data-city');
    const text_color = esgi_widget.getAttribute('data-text-color');
    const background = esgi_widget.getAttribute('data-background');

    widget_root.style.backgroundColor = background;
    widget_root.style.color = text_color;


    const title = document.createElement('h1');
    const temp = document.createElement('h2');
    const desc = document.createElement('p');
    const error_element = document.createElement('p');
    error_element.style.color = 'red';

    const data = fetch(`http://api.openweathermap.org/data/2.5/weather?q=${city}&lang=fr&units=metric&APPID=2e144d72721a5fea8f59e8a4300e551e`)
        .then((response) => response.json())
        .then((d) => {
            if (d.cod === 200) {
                title.innerHTML = d.name;
                temp.innerHTML = `${d.main.temp}°C`;
                desc.innerHTML = d.weather[0].description;
                esgi_widget.append(title, temp, desc);
            }
            else if (d.cod === 404) {
                error_element.innerHTML = `La ville ${city} n'existe pas`;
                esgi_widget.append(error_element);
            }
            else {
                error_element.innerHTML = `Une erreur inconnue s'est produite : ${d.message}` ;
                esgi_widget.append(error_element);
            }

        })
        .catch((e)=> {
            error_element.innerHTML = e;
            esgi_widget.append(error_element);
        });



});
