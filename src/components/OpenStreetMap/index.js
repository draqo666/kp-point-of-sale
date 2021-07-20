import React from "react";
import { Map, Marker, Circle, TileLayer, Popup } from "react-leaflet";
import MarkerClusterGroup from "react-leaflet-markercluster";
import FullscreenControl from "react-leaflet-fullscreen";

import L from "leaflet";
class OpenStreetMap extends React.Component {
  constructor(props) {
    super(props);
    this.state = {
      init: {
        geocords: {
          lat: 46.2440813,
          lng: 5.4653723
        },
        zoom: 14
      },
      markers: []
    };
  }

  componentDidMount = () => {
    this.setState(this.props);
  };

  render() {
    const style = { height: "100%" };
    let markers = this.props.markers.map((item, key) => {
      let icon = new L.Icon({
        iconUrl: item.icon,
        iconAnchor: [20, 20]
      });

      return (
        <Marker
          key={key}
          position={[item.geocords.lat, item.geocords.lng]}
          icon={icon}
        >
          <Popup className="kp-map-popup">
            <p className="mb-1" style={{ fontSize: `1.2rem` }}>
              {item.popupData.type}
            </p>
            <h2 className="title mb-1">ccc {item.popupData.title}</h2>
            <div className="kp-map-popup__details">
              {item.popupData.address ? (
                <div className="mb-1">
                  {item.popupData.city}, {item.popupData.address}
                </div>
              ) : null}
              {item.popupData.phone_mobile || item.popupData.phone ? (
                <div className="mb-1">
                  <img src={`${kpSettings.themeUrl}/assets/images/phone.png`} />

                  {item.popupData.phone ? (
                    <>
                      {item.popupData.phone}
                      <br />
                    </>
                  ) : null}

                  {item.popupData.phone_mobile
                    ? item.popupData.phone_mobile
                    : null}
                </div>
              ) : null}sss
              {item.popupData.whatsapp || item.popupData.messenger ? (
                <div className="mb-1">
                  {item.popupData.whatsapp (
                    <a href="https://api.whatsapp.com/send?phone=+48{item.popupData.whatsapp}"><img src={`${kpSettings.themeUrl}/assets/images/phone.png`} /></a>
                  ) : null}
                </div>
              ) : null}
              {item.popupData.email ? (
                <div className="mb-1">
                  <img
                    src={`${kpSettings.themeUrl}/assets/images/envelope.png`}
                  />
                  <a href={item.popupData.email}>{item.popupData.email}</a>
                </div>
              ) : null}
            </div>

            <div className="mb-5 mt-5">
              <a
                className="krispol_button krispol_button_orange"
                href={item.popupData.link}
              >
                {kpTranslate["more"]}
              </a>
            </div>
          </Popup>
        </Marker>
      );
    });
    return (
      <Map
        center={[this.state.init.geocords.lat, this.state.init.geocords.lng]}
        zoom={this.state.init.zoom}
        maxZoom={18}
        style={style}
      >
        <FullscreenControl position="topleft" />
        <TileLayer
          url="https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png"
          attribution='&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
        />
        {this.props.init.distance > 0 ? (
          <Circle
            center={[
              this.state.init.geocords.lat,
              this.state.init.geocords.lng
            ]}
            fillColor="blue"
            radius={this.props.init.distance}
          />
        ) : null}

        <MarkerClusterGroup>{markers}</MarkerClusterGroup>
      </Map>
    );
  }
}

export default OpenStreetMap;
