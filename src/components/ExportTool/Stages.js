import React, { useContext } from "react";
import { StageContext } from "./ExportTool";
import { Steps } from "antd";

const Step = Steps.Step;
export const Stages = () => {
  const [stage] = useContext(StageContext);
  return (
    <Steps size="small" current={stage}>
      <Step title="Wybierz dane" />
      <Step title="Pobierz plik" />
    </Steps>
  );
};
