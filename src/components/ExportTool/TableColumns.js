import Taxonomy from "./Taxonomy";
import React from "react";
import { getColumnSearchProps } from "./Search";
const Columns = [
  {
    title: "ID",
    dataIndex: "id",
    defaultSortOrder: "descend",
    sorter: (a, b) => a.key - b.key
  },
  { 
    title: "Title", 
    dataIndex: "title", 
    ...getColumnSearchProps("title") 
  },
  {
    title: "Address",
    dataIndex: "kp_address",
    ...getColumnSearchProps("kp_address")
  },
  {
    title: "Email",
    dataIndex: "kp_email",
    ...getColumnSearchProps("kp_email")
  },
  {
    title: "Email Form",
    dataIndex: "kp_email_form",
    ...getColumnSearchProps("kp_email_form")
  },
  {
    title: "Facebook link",
    dataIndex: "kp_facebook_url"
  },
  {
    title: "Fax",
    dataIndex: "kp_fax",
    ...getColumnSearchProps("kp_fax")
  },
  {
    title: "Lat",
    dataIndex: "kp_geo_cords_lat"
  },
  {
    title: "Lng",
    dataIndex: "kp_geo_cords_lng"
  },
  {
    title: "Phone",
    dataIndex: "kp_phone",
    ...getColumnSearchProps("kp_phone")
  },
  {
    title: "Mobie Phone",
    dataIndex: "kp_phone_mobile",
    ...getColumnSearchProps("kp_phone_mobile")
  },
  {
    title: "Język",
    dataIndex: "kp_lang",
    ...getColumnSearchProps("kp_lang")
  },
  {
    title: "WWW",
    dataIndex: "kp_www"
  },
  {
    title: "Typ placówki",
    dataIndex: "typ_placowki",
    render: (_, record) => {
      const placowka = arr => {
        record.typ_placowki = arr.join(", ");
      };
      return <Taxonomy placowka={placowka} id={record.id} typ="Placówka" />;
    }
  },
  {
    title: "Typ oferty",
    dataIndex: "typ_oferty",
    render: (_, record) => {
      const oferta = arr => {
        record.typ_oferty = arr.join(", ");
      };
      return <Taxonomy oferta={oferta} id={record.id} typ="Oferta" />;
    }
  },
  {
    title: "Miasto",
    dataIndex: "miasto",
    render: (_, record) => {
      const miasto = arr => {
        record.miasto = arr.join(", ");
      };
      return <Taxonomy miasto={miasto} id={record.id} typ="Miasto" />;
    }
  },
  {
    title: "Certyfikaty",
    dataIndex: "certyfikat",
    render: (_, record) => {
      const certyfikat = arr => {
        record.certyfikat = arr.join(", ");
      };
      return (
        <Taxonomy certyfikat={certyfikat} id={record.id} typ="Certyfikat" />
      );
    }
  }
];
export default Columns;
