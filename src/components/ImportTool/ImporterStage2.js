import React from 'react';
import { Select, Form, Button } from 'antd';
import axios from 'axios'
import slugify from 'slugify'
import equals from 'array-equal'

const Option = Select.Option;


class ImporterStage2Form extends React.Component { 
    constructor(props) {
        super()
        this.state = {
            selectList: [],
            selectListModel: []
        }
    }
    componentWillMount() {
        /**
         * Get model fields
         */
        let model = [
            'kp_address', 
            'kp_phone',
            'kp_phone_mobile',
            'kp_fax',
            'kp_email', 
            'kp_email_form', 
            'kp_www',
            'kp_facebook_url',
            'kp_geo_cords_lat', 
            'kp_geo_cords_lng',
            'kp_lang'
        ] // TODO Nie można pobierać obiektu ponieważ gdy nie ma żadnych danych wyświetla undefied. Strukturę dobrze by 
        model.push('title');
        // TODO Trzeba to pobierać z Wordpress, a nie hardcode
        model.push('miasto');
        model.push('typ_placowki');
        model.push('typ_oferty');
        model.push('certyfikat');

        this.setState({
            selectListModel: model, // This is model from API
            selectList: model // This is current state Options
        })

    }
    handleChange(e) {
        e.preventDefault();
        let stage
        this.props.form.validateFields((err, values) => {
            if (!err) {
                stage = 3
            } else {
                stage = 2
            }
            this.props.outputData({
                stage: stage,
                selectedColumns: values
            })
        });


    }
    componentDidUpdate(prevProps, prevState) {    
        let fieldsChanged = this.props.form.getFieldsValue()
        let output = Object.values(fieldsChanged);
        let filtered = this.state.selectListModel.filter(function(value, index, arr){
            if(!output.includes(value)) {
                return value
            }
        })

        if(equals(filtered, this.state.selectList) === false) {
            if(prevState.selectList.length > 0) {
                this.setState({
                    selectList: filtered
                })
            }
        } 
    }
    render() {
        const { getFieldDecorator } = this.props.form;
        let title; 

        let selectList ;
        if(this.state.selectList !== null) {
            selectList = this.state.selectList
            selectList = selectList.map((e,k) => {
                return(<Option value={e} key={k}>{e}</Option>)
            })
        }
        
        let columns = this.props.inputData.columns.map((e, key) => {
            title = slugify(e.title, {
                replacement: '_',
                remove: null,
                lower: true
            })
            return (
                <Form.Item style={{ marginBottom: 20 }} label={e.title} key={key}>
                    {getFieldDecorator(title, {
                        rules: [{ required: false, whitespace: true  }]
                    })(
                        <Select style={{ width: 250 }} >
                            {selectList}
                        </Select>
                    )}
                </Form.Item>
            )
        });

        let ids = this.props.inputData.columns.map((e,k) => {
            title = slugify(e.title, {
                replacement: '_',
                remove: null,
                lower: true
            })
            return(<Option value={title} key={k}>{e.title}</Option>)
        })

        return (
            <Form labelCol={{ span: 5 }} wrapperCol={{ span: 12 }} onSubmit={this.handleChange.bind(this)}>
                <h1>Dopasuj pole referencyjne</h1>
                <Form.Item style={{ marginBottom: 20 }} label='ID' extra="Zaznacz pole ID według którego będziemy porównywać wpisy.">
                    {getFieldDecorator('id', {
                        rules: [{ required: true, message: 'Musisz zaznaczyć według którego pola mamy porówywać wpisy.'  }]
                    })(
                        <Select style={{ width: 250 }} >
                            {ids}
                        </Select>
                    )}
                </Form.Item>
                <hr/>
                <h1>Dopasuj pola:</h1>
                {columns}
                <Form.Item>
                    <Button type="primary" htmlType="submit">
                        Dalej
                    </Button>
                </Form.Item>
            </Form>
        )
    }
}

const ImporterStage2 = Form.create({name: 'ImporterStage2Form'})(ImporterStage2Form)

export default ImporterStage2