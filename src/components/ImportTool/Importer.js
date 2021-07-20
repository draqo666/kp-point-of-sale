import React from 'react';
import FileUploader from './FileUploader'
import ImporterStage1 from './ImporterStage1';
import ImporterStage2 from './ImporterStage2';
import ImporterStage3 from './ImporterStage3';
import { Progress, Row } from 'antd';

class Importer extends React.Component { 
    constructor(props) {
        super() 
        this.state = {
            stage: 1,
        }
    }
    handleData(output) {
        if(output.stage === 1) {
            this.setState({
                data: output.data,
                stage: output.stage+1 // I change state for go to next stage
            })
            this.props.output({
                stage: 1 // I deliver props to step component
            })
        } else if(output.stage === 2) {
            this.setState({
                data: {
                    columns: output.data.columns,
                    rows: output.data.rows
                },
                selectedRowKeys: output.data.selectedRowKeys,
                stage: output.stage+1 // I change state for go to next stage
            })
            this.props.output({
                stage: 2 // I deliver props to step component
            })
        } else if (output.stage === 3) {
            this.setState({
                selectedColumns: output.selectedColumns,
                stage: output.stage+1 // I change state for go to next stag
            })
            this.props.output({
                stage: 3 // I deliver props to step component
            })
        } else if (output.stage === 4) {
            this.setState({
                stage: output.stage+1// I change state for go to next stage
            })
            this.props.output({
                stage: 4 // I deliver props to step component
            })
        }
        //console.log('Obecny stan:', this.state)
        //console.log('Otrzyuję dane:', output);
    }

    render() {
        if(this.state.stage === 1) {
            return(<FileUploader data={this.handleData.bind(this)} />)
        } else if(this.state.stage === 2) {
            return(<ImporterStage1 inputData={this.state.data} outputData={this.handleData.bind(this)} />)
        } else if (this.state.stage === 3) {
            return(<ImporterStage2 inputData={this.state.data} outputData={this.handleData.bind(this)}  />)
        } else if (this.state.stage === 4) {
            return (<ImporterStage3 inputData={this.state} outputData={this.handleData.bind(this)} />)
        } else if (this.state.stage === 5) { // TODO Trzeba to wyśrodkować
            return (
                <Row justify='center'>
                    <Progress type="circle" percent={100} />
                </Row>
            )
        } else {
            return (<div>Coś poszło nie tak. Skontaktuj się z administratorem.</div>);
        }
    }
}
export default Importer