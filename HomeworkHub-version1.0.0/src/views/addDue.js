import React from "react";
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

import EmployeeList from './components_due/EmployeeList';
import EmployeeContextProvider from './contexts_due/EmployeeContext';
import "./App.css";



class addDue extends React.Component {

  constructor(props) {
    super(props);
    this.state={
      username: localStorage.getItem("username"),
      homeworks: []
    };
    this.addHomework = this.addHomework.bind(this);
    this.getHomeworks = this.getHomeworks.bind(this);
    this.deleteHomework = this.deleteHomework.bind(this);
    
    this.getHomeworks();
  }

  getHomeworks() {
    const url = "/HomeworkHub/backend/get_teacher_event_list_for_all_classrooms.php";
      let formData = new FormData();
      let data = '{"username":"' + this.state.username + '", "type":"homework"}';
      formData.append("formData", data);
      axios.post(url, formData)
      .then(response => {
        var res = response["data"];
        this.setState({homeworks: [...res]});
     })
     .catch(err=>console.log(err.response, err.request));
  }

  addHomework(id, name, desc, date, points) {
    const url = "/HomeworkHub/backend/create_event.php";
    let formData = new FormData();
    let data = '{"type":"homework", "name":"' + name + '", "description":"' + desc + '", "duedate":"' + date + '", "classroomid":"' + id + '", "points":"' + points + '"}';
    console.log(data);
    formData.set("formData", data);
    axios.post(url, formData)
    .then(response => {
      var res = response["data"];
      this.setState({homeworks: [...res]});
    })
    .catch(err=>console.log(err));
    this.getHomeworks();
  }

  deleteHomework(homeworkid) {
    const url = "/HomeworkHub/backend/delete_event.php";
    let formData = new FormData();
    let data = '{"eventid":"' + homeworkid + '", "type":"homework"}';
    formData.append("formData", data);
    axios.post(url, formData)
    .then(response => {
      var res = response["data"];
      console.log(res);
    })
    .catch(err=>console.log(err.response, err.request));
    this.getHomeworks();
  }

  updateHomework() {

  }
 
  render() {
    
    
    return (
      <div className="container-xl">
        <div className="table-responsive">
          <div className="table-wrapper">
            <EmployeeList homeworks={this.state.homeworks} addHomework={this.addHomework} deleteHomework={this.deleteHomework} updateHomework={this.updateHomework}/>
          </div>
        </div>
      </div>
    );
  }
}
export default addDue;
