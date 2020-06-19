<script>
	var property = document.getElementsByClassName('address-location-input')
 	var prop_length = property.length

 	var start_lat = property[0].getAttribute('data-latitude')
	var start_long = property[0].getAttribute('data-longitude')
	console.log(start_lat)
	console.log(start_long)
	var start_lat = 35.149532
	var start_long = -90.048981

	var map = L.map('location-map-container', { dragging: !L.Browser.mobile, tap: !L.Browser.mobile }).setView([start_lat, start_long], 5);

	var osmUrl = 'https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png';

	var attribution = '&copy; <a href="https://www.openstreetmap.org/copyright">'

    var osmLayer = new L.TileLayer(osmUrl, {
        maxZoom: 19,
        attribution: attribution
    });
	map.addLayer(osmLayer);
    var markers = [];
   
	var blackIcon = new L.Icon({
	  iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-black.png',
	  shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
	  iconSize: [25, 41],
	  iconAnchor: [12, 41],
	  popupAnchor: [1, -34],
	  shadowSize: [41, 41]
	});

	for(var i = 0; i < prop_length; i++ ){
	
		var officeName = property[i].getAttribute('data-office-name')
		console.log(officeName)
		var propAddress = property[i].getAttribute('data-address')
		var encoded_address = encodeURI(propAddress)

		var address_link = "<a href='https://www.google.com/maps/dir//" + encoded_address + "'' target='_blank'>"+propAddress+"</a>";

		var point = '<div id="point_' + property[i].innerHTML.replace(/\s/g,'_') + '" style="width: 270px;"><p style="margin-top:0; margin-bottom:6px !important; font-weight:bold;">'+ officeName +'</p><p  style="font-size:13px; margin-top:0; margin-bottom:0px !important;">' + address_link + '</p></div>';

		var lat = property[i].getAttribute('data-latitude')
		var long = property[i].getAttribute('data-longitude')
		var marker = L.marker([lat, long],{icon: blackIcon, title:"marker_" + i}).addTo(map).bindPopup(point);
		markers.push(marker);
	}
    
    function markerFunction(id){
        for (var i in markers){
            var markerID = markers[i].options.title;
            if (markerID == id){
                markers[i].openPopup();
            };
        }
    }


	map.scrollWheelZoom.disable()
</script>