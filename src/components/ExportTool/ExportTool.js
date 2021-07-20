import React, { useState } from "react";
import { Layout } from "antd";
import Exporter from "./Exporter";

import { Stages } from "./Stages";

const { Content } = Layout;
export const StageContext = React.createContext(0);
export const DataContext = React.createContext([]);
export const ExportTool = () => {
  const [stage, setStage] = useState(0);
  const [data, setData] = useState([]);
  return (
    <StageContext.Provider value={[stage, setStage]}>
      <Content style={{ padding: "0 50px", marginTop: 20 }}>
        <Stages />
      </Content>
      <Content style={{ padding: "0 50px", marginTop: 20 }}>
        <DataContext.Provider value={[data, setData]}>
          <Exporter />
        </DataContext.Provider>
      </Content>
    </StageContext.Provider>
  );
};
