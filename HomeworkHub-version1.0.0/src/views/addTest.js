import React, { useState } from "react";
import axios from "axios";
import {
  Badge,
  Button,
  Card,
  Navbar,
  Nav,
  Table,
  Container,
  Row,
  Col,
  Dropdown,
  Pagination
} from "react-bootstrap";

import EmployeeList from './components_test/EmployeeList';
import EmployeeContextProvider from './contexts_test/EmployeeContext';
import "./App.css";

class addTest extends React.Component {

    constructor(props) {
      super(props);
      this.state = {
        username: localStorage.getItem("username"),
        tests: []
      }

      this.deleteTest = this.deleteTest.bind(this);
      this.addTest = this.addTest.bind(this);
      this.getTests = this.getTests.bind(this);
      this.updateTest = this.updateTest.bind(this);

      this.getTests();
    }

    getTests() {
      const url = "/HomeworkHub/backend/get_teacher_event_list_for_all_classrooms.php";
      let formData = new FormData();
      let data = '{"username":"' + this.state.username + '", "type":"test"}';
      //console.log(data);
      formData.append("formData", data);
      axios.post(url, formData)
      .then(response => {
        var res = response["data"];
        this.setState({tests: [...res]});
     })
     .catch(err=>console.log(err.response, err.request));
    }

    addTest(id, name, date, limit, points, desc) {
      const url = "/HomeworkHub/backend/create_event.php";
      let formData = new FormData();
      let data = '{"type":"test", "name":"' + name + '", "description":"' + desc + '", "duedate":"' + date + '", "classroomid":"' + id + '", "points":"' + points + '", "timelimit":"' + limit + '"}';
      console.log(data);
      formData.set("formData", data);
    
      axios.post(url, formData)
      .then(response => {
         var res = response["data"];
         console.log(res);
      })
      .catch(err=>console.log(err));
      this.getTests();
    }

    deleteTest(testid) {
      const url = "/HomeworkHub/backend/delete_event.php";
      let formData = new FormData();
      let data = '{"eventid":"' + testid + '", "type":"test"}';
      //console.log(data);
      formData.append("formData", data);
      axios.post(url, formData)
      .then(response => {
        var res = response["data"];
        console.log(res);
     })
     .catch(err=>console.log(err.response, err.request));
    this.getTests();
    }

    updateTest(eventid, name, desc, date, limit, points) {
      const url = "/HomeworkHub/backend/update_event.php";
      let formData = new FormData();
      let data = '{"type":"test", "eventid":"'+eventid+'", "name":"' + name + '", "description":"' + desc + '", "duedate":"' + date + '", "points":"' + points + '", "timelimit": "' + limit + '"}';
      formData.set("formData", data);
      axios.post(url, formData)
      .then(response => {
         var res = response["data"];
         if (res == 0) {console.log("success");}
      })
      .catch(err=>console.log(err));
      this.getTests();
    }
  
    render() {
      return (
        <div className="container-xl">
          <div className="table-responsive">
            <div className="table-wrapper">
                <EmployeeList tests={this.state.tests} addTest={this.addTest} deleteTest={this.deleteTest} updateTest={this.updateTest}/>
            </div>
          </div>
        </div>
      );
}
}

export default addTest;