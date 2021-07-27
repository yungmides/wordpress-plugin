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
    const data = fetch(`http://api.openweathermap.org/data/2.5/weather?q=${city}&lang=fr&units=metric&APPID=2e144d72721a5fea8f59e8a4300e551e`)
        .then((response) => response.json())
        .then((d) => {
            title.innerHTML = d.name;
            temp.innerHTML = `${d.main.temp}°C`;
            desc.innerHTML = d.weather[0].description
        })
        .catch((e)=>console.error(e));

    esgi_widget.append(title, temp, desc);



});
