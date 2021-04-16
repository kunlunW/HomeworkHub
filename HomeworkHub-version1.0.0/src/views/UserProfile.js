import React, { useState } from 'react';
import axios from "axios";
import {
  Container,
  Row,
  Col,
  Card,
  Form, 
  Button,
  Carousel
} from "react-bootstrap";
import FormikForm from './FormikForm';

class User extends React.Component {

  constructor(props) {
    super(props);
    this.state = {
      name: localStorage.getItem("username"),
      gender: "",
      email: "",
      mobile_no: "",
      school: ""
    };
    this.updateFields = this.updateFields.bind(this);
    this.getInfo();

  }   
  
  getInfo() {
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

  updateFields(values) { 
    this.setState({
      gender: values.gender,
      email: values.email,
      mobile_no: values.mobile_no,
      school: values.school
    });
    
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

  render() {
     return (
      <>
      <Container fluid>
        <Row>
          <Col md="10">
            
            <Card>
              

              <Card.Body>
                

                <FormikForm fields={this.state} updateFields={this.updateFields}/>


              </Card.Body>

            </Card>

          </Col>
        </Row>
      </Container>
      </>
      );
  }
}
export default User;
