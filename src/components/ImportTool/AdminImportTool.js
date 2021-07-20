import React from 'react';
import { Layout } from 'antd';
import * as Sentry from '@sentry/browser';
Sentry.init({dsn: "https://a6192606c6de444ba353cd4f951d5be9@sentry.io/1519424"});
import Importer from './Importer'
import Stages from './Stages';

const { Content } = Layout;

class AdminImportTool extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            data: null,
            stage: 0
        }
    }
    onChangeData(e) {
        this.setState({
            stage: e.stage
        })
    }
    render() {
        return(
            <div>
                <Content style={{ padding: '0 20px', marginTop: 20 }}>
                    <Stages stage={this.state.stage} />
                </Content>
                <Content style={{ padding: '0 20px', marginTop: 20 }}>
                    <Importer data={this.state.data} output={this.onChangeData.bind(this)} />
                </Content>
            </div>
        )
    }
}
export default AdminImportTool;

