import React from 'react';
import ReactDOM from 'react-dom';
import * as XLSX from 'xlsx';

class ExcelToJsonInput extends React.Component{
    constructor(props){
        super(props);
        this.state={
            file:null,
            data:null
        };

        //Bind this to functions (Arrow Operator not working)
        this.updateFile = this.updateFile.bind(this);
    }
    render(){
        return (
            <div className="row justify-content-center" ref="parent">
                <div className="col-4 mx-3">
                    <div className="input-group my-4">
                        <div className="custom-file">
                            <input type="file" className="custom-file-input" onChange={this.updateFile.bind(this)} accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" multiple/>
                            <label className="custom-file-label">{this.state.file?this.state.file.name:'Choose Files'}</label>
                        </div>
                        <div className="input-group-append">
                            <button className="btn btn-outline-secondary" type="submit" disabled={this.state.data==null}>Upload</button>
                        </div>
                    </div>
                    <input type="hidden" name="data" value={JSON.stringify(this.state.data)}></input>
                </div>
            </div>
        );
    }
    updateFile(e){
        for (let index = 0; index < e.target.files.length; index++) {
            const file = e.target.files[index];
            console.log('zones',file)
            this.FileToJson(file)
        }
    }
    FileToJson(file){
        var name = file.name;
        console.log('processing file: ', name)
        const reader = new FileReader();
        reader.onload = (evt) => {
                /* Parse data */
                const bstr = evt.target.result;
                const wb = XLSX.read(bstr, {type:'binary'});
                /* Get first worksheet */
                const wsname = wb.SheetNames[0];
                const ws = wb.Sheets[wsname];
                /* Convert array of arrays */
                const data = XLSX.utils.sheet_to_json(ws);
                /* Update state */
                console.log("Data>>>",data);
                if(this.state.data){
                    this.setState({
                        data: this.state.data.concat(data)
                    })
                }
                else{
                    this.setState({
                        data:data
                    })
                }
            };
        reader.readAsBinaryString(file);
    }
}
export default ExcelToJsonInput;
if (document.getElementById('excel_input')) {
    ReactDOM.render(<ExcelToJsonInput />, document.getElementById('excel_input'));
}
