import React, { useState, useEffect, useContext } from "react";
import { Table, Button } from "antd";
import axios from "axios";
import Columns from "./TableColumns";
import { StageContext, DataContext } from "./ExportTool";
const ExporterStage1 = () => {

  const columns = Columns;
  const [selectedRows, setSelectedRows] = useState([]);
  const [data, setData] = useContext(DataContext);
  const [rows, setRows] = useState(data);
  const [loading, setLoading] = useState(true);
  const [, setStage] = useContext(StageContext);
  const hasSelected = selectedRows.length > 0;

  const [page, setPage] = useState(1);
  console.log(selectedRows);
  useEffect(() => {
    setRows(data);
  }, [data]);
  const rowSelection = {
    onChange: (_, selectedRows) => {
      setSelectedRows(selectedRows);
      console.log(selectedRows)
    }, 
    hideDefaultSelections: true,

  };
  const exportData = () => {
    setData(selectedRows);
    setStage(1);
  };

  useEffect(() => {
    const fetchData = async page => {
      setData([])
      setLoading(true);
      let newData = [];
      let respMergeData = [];
      let response = await axios({
        method: 'get',
        url: `/?rest_api=true&endpoint=point-of-sales`,
        headers: {
          'Cache-Control': 'no-cache',
          'Content-type': 'application/json',
        }
      });
      respMergeData = [...response.data];
      
      let arr = []
      for(let i = 2; i<= parseInt(response.headers["x-wp-totalpages"]); i++) {
        arr.push(i)
      }
      await Promise.all((arr.map(async (i) => {
        response = await axios({
          method: 'get',
          url: `/?rest_api=true&endpoint=point-of-sales`,
          headers: {
            'Cache-Control': 'no-cache',
            'Content-type': 'application/json',
          }
        });
        respMergeData = [...respMergeData, ...response.data];
      })));

      respMergeData.map(item => {
        let newItem = {};
        if (item.acf.kp_address === null) return;
        Object.entries(item.acf).forEach(([key, value]) => {
          newItem[key] = value;
        });
        newItem.title = item.title.rendered;
        newItem.id = Number(item.id);
        newData.push(newItem);
      });

      setData(newData);
      setLoading(false);
    };
    fetchData(page);
  }, [page]);

  return (
    <div>
      <span style={{ marginLeft: 8 }}>
        {hasSelected ? `Zaznaczono ${selectedRows.length} rzecz/y ` : ""}
      </span>
      <Table
        rowKey={record => record.id}
        pagination={{
          defaultPageSize: 1000,
          position: 'bottom',
        }}
        dataSource={rows}
        rowSelection={rowSelection}
        columns={columns}
        loading={loading}
      />
      <div style={{ marginBottom: 16 }}>
        <Button type="primary" disabled={!hasSelected} onClick={exportData}>
          Dalej
        </Button>
      </div>

    </div>
  );
};
export default ExporterStage1;
