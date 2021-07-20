import React from "react";
import ReactDOM from "react-dom";
import SearchEngine from './components/SerachEngine/index'
import OpenStreetMap from './components/OpenStreetMap/index'

if (!global._babelPolyfill) {
  require("@babel/polyfill");
}

window.onload = function() {
  if (document.getElementById("kpSearchForm")) {
    ReactDOM.render(
      <SearchEngine />,
      document.getElementById("kpSearchForm")
    );
  }

  if (document.getElementById("kpMap")) {
    let elem = document.getElementById("kpMap");
    let props = JSON.parse(elem.dataset.config)
    ReactDOM.render(
      <OpenStreetMap {...props} />,
      document.getElementById("kpMap")
    );
  }
};