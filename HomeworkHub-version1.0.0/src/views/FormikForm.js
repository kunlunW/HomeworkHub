import React, { Component } from 'react';
import axios from "axios";
import { withFormik, Form, Field } from 'formik';

const form_id = 'form_id';
class MaintenanceForm extends Component {

    constructor(props) {
        super(props);
        this.state = {
          name: localStorage.getItem("username"),
          gender: "",
          email: "",
          mobile_no: "",
          school: ""
        };
        this.save = this.save.bind(this);

        this.getUserInfo();

    }

    //This part is good and working
    getUserInfo() {

        const url = "/HomeworkHub/backend/displayTeacher.php";
        let formData = new FormData();
        let data = '{"username":"' + this.state.name + '"}';
        formData.append("formData", data);
        axios.post(url, formData)
        .then(response => {
            var res = response["data"][0];
            this.setState({
                gender: res["gender"],
                email: res["email"],
                mobile_no: res["mobile_no"],
                school: res["school"]
            });
        })
        .catch(err=>console.log(err.response, err.request));

    }


    //need to work on this
    save() {
      
        const url = "/HomeworkHub/backend/updateTeacher.php";
        let formData = new FormData();
        let data = '{"username":"' + this.state.name + '", "gender":"' + this.state.gender 
                                   + '", "email":"' + this.state.email 
                                   + '", "mobile_no":"' + this.state.mobile_no 
                                   + '", "school":"' + this.state.school + '"}';
        formData.append("formData", data);
        console.log(data);
        axios.post(url, formData)
        .then(response => {
            var res = response["data"];
            console.log(res);
            
        })
        .catch(err=>console.log(err.response, err.request));

    }

    editOnClick = (event) => {
        event.preventDefault()
        const data = !(this?.props?.status?.edit)
        this.props.setStatus({
            edit: data,
        })
    }
    
    cancelOnClick = (event) => {
        event.preventDefault()
        this.props.resetForm()
        this.props.setStatus({
            edit: false,
        })
    }

    _renderAction() {
        return (
            <React.Fragment>
                <div className="form-statusbar">
                    {
                        this?.props?.status?.edit ? 
                        <React.Fragment>
                            <button className="btn btn-primary btn-sm" form={form_id} type="submit" onClick={this.save}>Save</button> 
                            <button className="btn btn-danger btn-sm" onClick={this.cancelOnClick} style={{marginLeft: "8px"}}>Cancel</button>
                        </React.Fragment>
                        : 
                        <button className="btn btn-primary btn-sm" onClick={this.editOnClick}>Edit Profile</button> 
                    }
                </div>
            </React.Fragment>
        );
    }

    _renderFormView = () => {
        return (
            <React.Fragment>
                <div className="form-group row">
                    <label className="col-sm-2 col-form-label">UserName</label>
                    <div className="col-sm-10">
                        <label type="text" name="name" className="form-control">
                            {/* {this?.props?.fields?.name} */this.state.name}
                        </label>
                    </div>
                </div>

                <div className="form-group row">
                    <label className="col-sm-2 col-form-label">Gender</label>
                    <div className="col-sm-10">
                        <label type="text" name="name" className="form-control">
                            {/* {this?.props?.fields?.gender} */this.state.gender}
                        </label>
                    </div>
                </div>


                <div className="form-group row">
                    <label className="col-sm-2 col-form-label">Email</label>
                    <div className="col-sm-10">
                        <label type="text" name="brand_name" className="form-control"> 
                            {/* {this?.props?.fields?.email} */this.state.email}
                        </label>
                    </div>
                </div>

                <div className="form-group row">
                    <label className="col-sm-2 col-form-label">Mobile No</label>
                    <div className="col-sm-10">
                        <label type="text" name="device_type" className="form-control">
                            {/* {this?.props?.fields?.mobile_no} */this.state.mobile_no}
                        </label>
                    </div>
                </div>

                <div className="form-group row">
                    <label className="col-sm-2 col-form-label">School</label>
                    <div className="col-sm-10">
                        <label type="text" name="device_type" className="form-control">
                            {/* {this?.props?.fields?.school} */this.state.school}
                        </label>
                    </div>
                </div>
            </React.Fragment>
        );
    }

    _renderFormInput = () => {
        return (
            <React.Fragment>
                <div className="form-group row">
                    <label className="col-sm-2 col-form-label">UserName</label>
                    <div className="col-sm-10">
                        <Field type="text" name="name" className="form-control" placeholder="Name" ref={(n) => this.name = n}/> 
                    </div>
                </div>

                <div className="form-group row">
                    <label className="col-sm-2 col-form-label">Gender</label>
                    <div className="col-sm-10">
                        <Field type="text" name="gender" className="form-control" placeholder="Gender" />
                    </div>
                </div>

                <div className="form-group row">
                    <label className="col-sm-2 col-form-label">Email</label>
                    <div className="col-sm-10">
                        <Field type="text" name="email" className="form-control" placeholder="Email" />
                    </div>
                </div>
                <div className="form-group row">
                    <label className="col-sm-2 col-form-label">Mobile No</label>
                    <div className="col-sm-10">
                        <Field type="text" name="mobile_no" className="form-control" placeholder="Mobile No" />
                    </div>
                </div>

                <div className="form-group row">
                    <label className="col-sm-2 col-form-label">School</label>
                    <div className="col-sm-10">
                        <Field type="text" name="school" className="form-control" placeholder="school" />
                    </div>
                </div>
            </React.Fragment>        
        );
    }

    render() {
        return (
            <React.Fragment>
                <h2>Edit Profile</h2>
                {this._renderAction()}
                <br/>
                <Form id={form_id}>
                    {
                        this?.props?.status?.edit 
                        ?
                        this._renderFormInput()
                        :
                        this._renderFormView()
                    }
                </Form>
                <h4>Confirm your information</h4>
                <div>
                    <pre>
                        <code>{JSON.stringify(this.state, null, 2)}</code>
                    </pre>
                </div>
            </React.Fragment>
        );
    }
}

const FormikForm = withFormik({
    mapPropsToStatus: (props) =>  {
        return {
            edit: props?.edit || false,
        }
    },
    mapPropsToValues: (props) => {
        return {
            name: props.fields.name,
            gender: props.fields.gender,
            email: props.fields.email,
            mobile_no: props.fields.mobile_no,
            school: props.fields.school
        }
    }, 
    enableReinitialize: true,
    handleSubmit: (values, { props, ...actions }) => {
        props.updateFields(values);
        actions.setStatus({
            edit: false,
        });
    }
})(MaintenanceForm);

export default FormikForm;