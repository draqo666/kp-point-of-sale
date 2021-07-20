


/**
 * Generate maps
 */
function genMap(cords, domID, zoom, center = [52.237049, 19.017532]) {
    var icon;

    var tiles = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    });

    var map = L.map(domID, {
        center: center,
        zoom: zoom,
        layers: [tiles]
    });
    


    var markers = L.markerClusterGroup();

    cords.forEach(function(item) {
        icon = L.icon({
            iconUrl: item.icon,
            iconAnchor: [20, 40],
        })
        
        var marker = L.marker(
            [item.cords.let, item.cords.lng],
            {
                icon: icon
            })
            .on('click', function (e) {
                window.location = item.url;
            })

        markers.addLayer(marker);
    });


    map.addLayer(markers);

}

function scrollToElement(e)  {
    var pressL = e.which;
    var found = false;
    var i, child, L, secondChild;
    var x = 0;

    for(i = 0; i < el[0].childNodes.length; i++) {
        child = el[0].childNodes[i];

        if(child.className === 'city' || child.className === 'city active' && child.className !== 'city prev') {
            L = child.getAttribute('data-letter').charCodeAt(0);
            if(found !== true && child.className !== 'city active') {
                if(parseInt(L) === parseInt(pressL)) {
                    var scroll = child.offsetTop;
                    child.classList.add('active');
                    el[0].scroll({
                        top: scroll-450,
                        left: 0,
                        behavior: 'smooth'
                    });
                    found = true;
                }
            } else if (child.className === 'city active') {
                child.classList.remove('active');
                child.classList.add('prev');
            }
        }

        if(i === el[0].childNodes.length-1 && found === false) {
            for(x = 0; x < el[0].childNodes.length; x++) {
                //console.log(el[0].childNodes[x].className);
                secondChild = el[0].childNodes[x];
                if(secondChild.className === 'city prev') {
                    secondChild.classList.remove('prev');
                    L = secondChild.getAttribute('data-letter').charCodeAt(0);
                    if(found !== true) {
                        if(parseInt(L) === parseInt(pressL)) {
                            var scroll = secondChild.offsetTop;
                            secondChild.classList.add('active');
                            el[0].scroll({
                                top: scroll-450,
                                left: 0,
                                behavior: 'smooth'
                            });
                            found = true;
                        }
                    }
                } 
            }
        }
    }
    found = false;
}

