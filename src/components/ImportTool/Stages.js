import React from 'react';
import { Steps, Icon } from 'antd';

const Step = Steps.Step;

class Stages extends React.Component { 
    render() {
        
        return(
            <Steps size="small" current={this.props.stage}>
                <Step title="Dodaj pliki" />
                <Step title="Wybierz rekordy" />
                <Step title="Dopasuj nagłówki" />
                <Step title="Rozpocznij import" />
                <Step title="Zakończono"  />
            </Steps>
        )

    }
}
export default Stages;