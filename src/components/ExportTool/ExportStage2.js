import React, { useContext, useState } from "react";
import xlsx from "xlsx";
import { Button, Icon, Alert } from "antd";
import { DataContext } from "./ExportTool";
import { StageContext } from "./ExportTool";
const ExporterStage1 = () => {
  const [, setStage] = useContext(StageContext);
  const [data] = useContext(DataContext);
  const [loading, setLoading] = useState(0);
  const generateSheet = () => {
    setLoading(1);
    let workbook = xlsx.utils.book_new();
    let sheet = xlsx.utils.json_to_sheet(data);
    xlsx.utils.book_append_sheet(workbook, sheet, "Data");
    xlsx.writeFile(
      workbook,
      `${new Date().toISOString().slice(0, 10)}_data.xlsx`
    );
    setLoading(0);
  };
  if (loading) {
    <Alert message="We are generating your data, please wait" type="warning" />;
  } else {
    return (
      <>
        <div style={{ marginBottom: 8 }}>
          <Alert message="Twoje dane są gotowe do pobrania" type="success" />
        </div>
        <Button.Group>
          <Button type="primary" onClick={() => setStage(0)}>
            <Icon type="left" />
            Poprzedni krok
          </Button>
          <Button type="primary" onClick={generateSheet}>
            Pobierz
          </Button>
        </Button.Group>
      </>
    );
  }
};
export default ExporterStage1;
