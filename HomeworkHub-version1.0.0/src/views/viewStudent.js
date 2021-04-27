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

import EmployeeList from './components/EmployeeList';
import EmployeeContextProvider from './contexts/EmployeeContext';
import "./App.css";

class viewStudent extends React.Component {

  constructor(props) {
    super(props);
    this.state = {
      username: localStorage.getItem("username"),
      parents: []
    }
    this.getParents = this.getParents.bind(this);

    this.getParents();
  }

  getParents() {
    const url = "/HomeworkHub/backend/get_all_parents_in_all_classrooms_of_a_teacher.php";
    let formData = new FormData();
    let data = '{"username":"' + this.state.username + '"}';
    // console.log(data);
    formData.append("formData", data);
    axios.post(url, formData)
    .then(response => {
      var res = response["data"];
      console.log(res);
      this.setState({parents: [...res]});
      console.log(this.state.parents);
   })
   .catch(err=>console.log(err.response, err.request));
  }
  
  render() {
    return (
      <div className="container-xl">
        <div className="table-responsive">
          <div className="table-wrapper">
              <EmployeeList parents={this.state.parents} addParent={this.addParent} deleteParent={this.deleteParent} />
          </div>
        </div>
      </div>
    );
  }
}


export default viewStudent;
