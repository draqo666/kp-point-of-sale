import React, { Component } from 'react';
import XLSX from 'xlsx';
import { Upload, Icon, message } from 'antd';
import "antd/lib/upload/style/index.css";
import "antd/lib/message/style/index.css";
import "antd/lib/icon/style/index.css";

const Dragger = Upload.Dragger;
const props = {
    name: 'file',
    accept: '.xlsx, .xls',
    multiple: false,
    action: '',
    onChange(info) {
        const status = info.file.status;
        if (status === 'done') {
            message.success(`${info.file.name} file uploaded successfully.`);
        } else if (status === 'error') {
            message.error(`${info.file.name} file upload failed.`);
        }
    },
};

class FileUploader extends React.Component {
    constructor(props) {
        super(props)

        this.state = {
            data: null
        }
    }
    
    onChange(e) {
        var reader = new FileReader();
        var data = reader.readAsBinaryString(e)
        let json;
        let that = this;
        reader.onload = function(e) {
            data = e.target.result;
            var doc = XLSX.read(data, {type: 'binary'});            
            var worksheet = doc.Sheets[doc.SheetNames[0]];
            json = XLSX.utils.sheet_to_json(worksheet, {header: 1})
            that.props.data({
                stage: 1,
                data: json
            });
        }
    }

    render() {
        return (
            <Dragger {...props} beforeUpload={this.onChange.bind(this)}>
                <p className="ant-upload-drag-icon">
                    <Icon type="inbox" />
                </p>
                <p className="ant-upload-text">Kliknij lub przeciągnij plik do tego obszaru, aby go przesłać</p>
                <p className="ant-upload-hint"></p>
            </Dragger>
        )
    }
};
export default FileUploader;
