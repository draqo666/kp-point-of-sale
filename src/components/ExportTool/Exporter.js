import React, { useContext } from "react";
import { StageContext } from "./ExportTool";
import ExporterStage1 from "./ExportStage1";
import ExporterStage2 from "./ExportStage2";
function Exporter() {
  const [stage] = useContext(StageContext);
  if (stage == 0) {
    return <ExporterStage1 />;
  } else if (stage == 1) {
    return <ExporterStage2 />;
  } else {
    return <div>Something went wrong. Contact Administrator</div>;
  }
}
export default Exporter;
