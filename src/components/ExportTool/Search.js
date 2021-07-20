import React from "react";
import { Button, Input, Icon } from "antd";
import Highlighter from "react-highlight-words";
let searchText = "";
let searchInput = null;
export const getColumnSearchProps = dataIndex => ({
  filterDropdown: ({
    setSelectedKeys,
    selectedKeys,
    confirm,
    clearFilters
  }) => (
    <div style={{ padding: 8 }}>
      <Input
        ref={node => {
          searchInput = node;
        }}
        placeholder={`Search ${dataIndex}`}
        value={selectedKeys[0]}
        onChange={e => setSelectedKeys(e.target.value ? [e.target.value] : [])}
        onPressEnter={() => handleSearch(selectedKeys, confirm)}
        style={{ width: 188, marginBottom: 8, display: "block" }}
      />
      <Button
        type="primary"
        onClick={() => handleSearch(selectedKeys, confirm)}
        icon="search"
        size="small"
        style={{ width: 90, marginRight: 8 }}
      >
        Search
      </Button>
      <Button
        onClick={() => handleReset(clearFilters)}
        size="small"
        style={{ width: 90 }}
      >
        Reset
      </Button>
    </div>
  ),
  filterIcon: filtered => (
    <Icon type="search" style={{ color: filtered ? "#1890ff" : undefined }} />
  ),
  onFilter: (value, record) =>
    record[dataIndex]
      .toString()
      .toLowerCase()
      .includes(value.toLowerCase()),
  onFilterDropdownVisibleChange: visible => {
    if (visible) {
      setTimeout(() => searchInput.select());
    }
  },
  render: text => (
    <Highlighter
      highlightStyle = {{ backgroundColor: "#ffc069", padding: 0 }}
      searchWords = {[searchText]}
      autoEscape
      textToHighlight = { (text !== undefined) ? text.toString() : "" }
    />
  )
});
const handleSearch = (selectedKeys, confirm) => {
  confirm();
  searchText = selectedKeys[0];
};

const handleReset = clearFilters => {
  clearFilters();
  searchText = "";
};
