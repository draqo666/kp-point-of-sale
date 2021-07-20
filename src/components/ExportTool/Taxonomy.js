import React, { useState, useEffect } from "react";
import axios from "axios";
const Taxonomy = ({ id, typ, placowka, miasto, certyfikat, oferta }) => {
  const [name_from_arr, setNameFromArr] = useState([]);
  useEffect(() => {
    const fetchData = async () => {
      let response = {};
      const names = [];
      if (typ === "Placówka") {
        response = await axios.get(`/?rest_api=true&endpoint=point-of-sales/typ_placowki&post=${id}`);
      } else if (typ === "Oferta") {
        response = await axios.get(`/?rest_api=true&endpoint=point-of-sales/typ_oferty&post=${id}`);
      } else if (typ === "Miasto") {
        response = await axios.get(`/?rest_api=true&endpoint=point-of-sales/miasto&post=${id}`);
      } else if (typ === "Certyfikat") {
        response = await axios.get(`/?rest_api=true&endpoint=point-of-sales/certyfikat&post=${id}`);
      } else if (typeof typ !== undefined) {
        console.log("Typ jest pusty");
      } else {
        console.log("Typ jest undefined");
      }
      response.data.map(item => names.push(item.name));
      setNameFromArr(names);
      if (placowka !== undefined) placowka(names);
      if (miasto !== undefined) miasto(names);
      if (certyfikat !== undefined) certyfikat(names);
      if (oferta !== undefined) oferta(names);
    };
    fetchData();
  }, []);
  const names = name_from_arr.join(", ");
  return <p>{names === undefined || names.length === 0 ? "Empty" : names}</p>;
};
export default Taxonomy;
