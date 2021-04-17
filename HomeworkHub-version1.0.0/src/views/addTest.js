import React, { useState } from "react";

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
        tests: [{name: "hello", points: 11, date: "2021-04-03", limit: 140},{name: "hello", points: 11, date: "2021-04-03", limit: 140},{name: "hello", points: 11, date: "2021-04-03", limit: 140}]
      }

      this.deleteTest = this.deleteTest.bind(this);
      this.addTest = this.addTest.bind(this);
    }

    getTests() {
      //just need to add fetching the tests
    }

    addTest(name, time, limit, points) {
      //wired up
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