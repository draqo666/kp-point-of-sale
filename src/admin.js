import React from "react";
import ReactDOM from "react-dom";
import AdminImportTool from "./components/ImportTool/AdminImportTool";
import { ExportTool } from "./components/ExportTool/ExportTool";
import "antd/dist/antd.css";
if (!global._babelPolyfill) {
  require("@babel/polyfill");
}
if (document.getElementById("kpAdminImportTool")) {
  ReactDOM.render(
    <AdminImportTool />,
    document.getElementById("kpAdminImportTool")
  );
}
if (document.getElementById("kpAdminExportTool")) {
  ReactDOM.render(<ExportTool />, document.getElementById("kpAdminExportTool"));
}
