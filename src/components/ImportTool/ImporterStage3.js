import React from 'react';
import { Progress, Button } from 'antd';
import { throws } from 'assert';
import roundTo from 'round-to';
import importPost from './functions/ImportPost'
class ImporterStage3 extends React.Component { 
    constructor(props) {
        super()
        this.state = {
            progress: 0,
            syncStatus: 'wait',
            queueData: [],
            queueDataDone: [],
        }
    }

    componentDidMount() { 
        let that = this

        this.interval = setInterval(() => {
            if(this.state.syncStatus !== 'wait') {
                let queue = this.state.queueData;

                queue.forEach(e => {
                    this.setState({
                        progress: roundTo((this.state.queueDataDone.length*100)/queue.length,0)
                    })
                    if(this.state.syncStatus === 'ready') {
                        if(this.state.queueDataDone.indexOf(e.id) === -1) {
                            this.setState({syncStatus: 'posting'})
                            let queueDataDone = this.state.queueDataDone
                            importPost(e).then((resp) => {
                                queueDataDone.push(resp.id)
                                that.setState({
                                    syncStatus: 'ready',
                                    queueDataDone: queueDataDone
                                })
                                that.props.outputData({
                                    stage: 3
                                })
                            })
                            .catch((err) => {
                                console.error(err)
                            })
                        }
                    } 
                })
            } 

            if(this.state.progress === 100) {
                setTimeout(()=>{
                    that.props.outputData({
                        stage: 4
                    })
                }, 2000)
            }
        }, 200)
    }

    componentWillUnmount() {
        clearInterval(this.interval);
    }

    prepareQueue() {
        let config = this.props.inputData;
        let entryDataAll = [];

        config.data.rows.forEach((element, key) => {
            let entryData = {};
            let entryACF = {};
            let taxonomies = {};
            let idPost
            if(config.selectedRowKeys.indexOf(element.key) != -1) {
                let columns = Object.getOwnPropertyNames(element); // TODO to nie może być na sztywno, pobrać to z settingsów trzeba

                columns.forEach((e) => {

                    /**
                     * This parse acf fields
                     */
                    if(config.selectedColumns[e] !== undefined) {
                        entryACF[config.selectedColumns[e]] = element[e]
                    }

                    /**
                     * This parse taxonomies
                     */
                    if(config.selectedColumns[e] === 'miasto') {
                        taxonomies.miasto = element[e]
                    } else if (config.selectedColumns[e] === 'certyfikat') {
                        taxonomies.certyfikat = element[e]
                    } else if (config.selectedColumns[e] === 'typ_placowki') {
                        taxonomies.typ_placowki = element[e]
                    } else if (config.selectedColumns[e] === 'typ_oferty') {
                        taxonomies.typ_oferty = element[e]
                    }

                    /**
                     * This parse ids
                     */
                    if(config.selectedColumns['id'] !== undefined) {
                        idPost = element[config.selectedColumns['id']]
                    }

                    
                })
                
                entryData = {
                    id: key,
                    wordpressData: {
                        idPost: idPost,
                        title: entryACF.title,
                        fields: entryACF,
                        miasto: taxonomies.miasto,
                        certyfikat: taxonomies.certyfikat,
                        typ_placowki: taxonomies.typ_placowki,
                        typ_oferty: taxonomies.typ_oferty
                    }
                }
                entryDataAll.push(entryData)
            }
        });

        this.setState({
            queueData: entryDataAll,
            syncStatus: 'ready'
        })
        
        if(this.state.progress === 100) {
            this.props.outputData({
                stage: 3
            })
        }
    }

    render() {

        let btnText
        if(this.state.progress > 0) {
            btnText = "Aktualizuję..."
        } else {
            btnText = "Rozpocznij import"
        }
        return (
            <div style={{textAlign: 'center'}}>
                <Button type="primary" loading={(this.state.progress > 0) ? true : false } onClick={this.prepareQueue.bind(this)}>
                    {btnText}
                </Button>
                <Progress percent={this.state.progress} status={this.state.status} />
            </div>
        )
    }
}
export default ImporterStage3