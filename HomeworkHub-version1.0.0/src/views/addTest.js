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

      this.getTests();
    }

    getTests() {
      const url = "/HomeworkHub/backend/get_event_list.php";
      let formData = new FormData();
      let data = '{"classroomid":"' + this.state.classroomId + '", "type":"test"}';
      formData.append("formData", data);
      axios.post(url, formData)
      .then(response => {
        var res = response["data"];
        //  console.log(res);
        this.setState({tests: [...res]});
     })
     .catch(err=>console.log(err.response, err.request));
    }

    addTest(id, name, date, limit, points, desc) {
      const url = "/HomeworkHub/backend/create_event.php";
      let formData = new FormData();
      //let data = '{"type":"test", "name":"'+name+'", "description":"'+desc+'", "duedate":"'+date+'", "classroomid":"'+id+'", "points":"'+points+'", "limit:"'+limit+'"}';
      let data = '{"type":"test", "name":"' + name + '", "description":"' + desc + '", "duedate":"' + date + '", "classroomid":"' + id + '", "points":"' + points + '", "timelimit":"' + limit + '"}';
      console.log(data);
      formData.set("formData", data);
    
      axios.post(url, formData)
      .then(response => {
         var res = response["data"];
         console.log(res);
         //this.setState({announcements: [...res]});
      })
      .catch(err=>console.log(err));
    }

    deleteTest() {
      //wired up
    }

    updateTest() {
      //TODO
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