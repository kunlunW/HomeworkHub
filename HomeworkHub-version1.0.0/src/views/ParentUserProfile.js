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
import ParentFormikForm from './ParentFormikForm.js';

class ParentUser extends React.Component {

  constructor(props) {
    super(props);
    this.state = {
      name: localStorage.getItem("parentusername"),
      classroomId: localStorage.getItem("parentclassroomId"),
      email: "",
      mobile_no: "",
      school: ""
    };
    this.updateFields = this.updateFields.bind(this);
    this.getInfo();

  }   
  
  getInfo() {
    const url = "/HomeworkHub/backend/displayParent.php";
        let formData = new FormData();
        let data = '{"username":"' + this.state.name + '"}';
        formData.append("formData", data);
        axios.post(url, formData)
        .then(response => {
            var res = response["data"];
            this.setState({
                email: res["email"],
                mobile_no: res["mobile_no"],
                school: res["school"]
            });
        })
        .catch(err=>console.log(err));

  }

  updateFields(values) {   
      const url = "/HomeworkHub/backend/updateParent.php";
      let formData = new FormData();
      let data = '{"username":"' + values.name + '", "email":"' + values.email 
                                 + '", "mobile_no":"' + values.mobile_no 
                                 + '", "school":"' + values.school + '", "studentName":"0", "studentID":"0", "classroomID":"'
                                 + this.state.classroomId+'"}';          
      formData.append("formData", data);
      axios.post(url, formData)
      .then(response => {
        var res = response["data"];
        console.log("res: " +res);    
        if (res === 1 || res === 3) {
          this.getInfo();
        }
      })
      .catch(err=>console.log(err.response));

  }

  render() {
     return (
      <>
      <Container fluid>
        <Row>
          <Col md="10">
            
            <Card>
              

              <Card.Body>
                

                <ParentFormikForm fields={this.state} updateFields={this.updateFields}/>


              </Card.Body>

            </Card>

          </Col>
        </Row>
      </Container>
      </>
      );
  }
}
export default ParentUser;
