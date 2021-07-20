import React from 'react';
import { Table, Button } from 'antd';
import slugify from 'slugify'

class ImporterStage1 extends React.Component { 
    constructor(props) {
        super()
        this.state = {
            selectedRowKeys: [], // Check here to configure the default column
            loading: false,
            data: {
                columns: null,
                rows: null,
                selectedRowKeys: null
            }
        }
    }
    start() {
        this.props.outputData({ stage: 2, data: this.state.data })
        this.setState({
            selectedRowKeys: [],
            loading: false,
        });
    }

    onSelectChange(selectedRowKeys) {
        this.setState({ selectedRowKeys, data: {
            columns: this.state.data.columns,
            rows: this.state.data.rows,
            selectedRowKeys: selectedRowKeys
        }});
    }

    componentWillReceiveProps(nextProps) {
        let excelData = nextProps.inputData;
        /**
         * Prepare columns 
         */
        let data = {
            rows: [],
            columns: []
        };
        if(excelData !== null) {
            excelData[0].map((title) => {
                let dataIndex = title.toLowerCase()
                dataIndex = slugify(dataIndex, {
                    replacement: '_',
                    remove: null,
                    lower: true
                })
                data.columns.push({
                    title: title,
                    dataIndex: dataIndex
                });
            })
        }
        /**
         * Generate date from props to Antd props
         */

        let n = Object;
        if(nextProps.data !== null) {
            excelData.forEach((e, k) => {
                if(k>0) { // Because first row is header
                    n = { key: k-1 }
                    data.columns.forEach((x, y) => {
                        n[x.dataIndex] = e[y]
                    })
                    data.rows.push(n)
                }
            });
        } else {
            data.rows = [];
        }
        this.setState({
            data: data
        })
    }

    render() {
        
        const { loading, selectedRowKeys } = this.state;
        const rowSelection = {
            selectedRowKeys,
            onChange: this.onSelectChange.bind(this),
        };
        const hasSelected = selectedRowKeys.length > 0;

        return (
            <div>
                <Table pagination={false} rowSelection={rowSelection} columns={this.state.data.columns} dataSource={this.state.data.rows} />
                <div style={{ marginBottom: 16 }}>
                    <Button
                    type="primary"
                    onClick={this.start.bind(this)}
                    disabled={!hasSelected}
                    loading={loading}
                    >
                    Dalej
                    </Button>
                    <span style={{ marginLeft: 8 }}>
                    {hasSelected ? `Zaznaczono ${selectedRowKeys.length} rzecz/y` : ''}
                    </span>
                </div>

            </div>
        )
    }
}
export default ImporterStage1