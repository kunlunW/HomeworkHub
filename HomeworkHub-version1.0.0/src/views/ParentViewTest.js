import React, { useState } from "react";
import axios from "axios";

import EmployeeList from './components_test_parent/EmployeeList';
import "./App.css";

class ParentViewTest extends React.Component {

    constructor(props) {
      super(props);
      this.state = {
        username: localStorage.getItem("parentusername"),
        classroomId: localStorage.getItem("parentclassroomId"),
        tests: []
      }

      this.getTests = this.getTests.bind(this);

      this.getTests();
    }

    getTests() {
      const url = "/HomeworkHub/backend/get_event_list.php";
      let formData = new FormData();
      let data = '{"classroomid":"' + this.state.classroomId + '", "type":"test"}';
      //console.log(data);
      formData.append("formData", data);
      axios.post(url, formData)
      .then(response => {
        var res = response["data"];
        this.setState({tests: [...res]});
     })
     .catch(err=>console.log(err.response, err.request));
    }
  
    render() {
      return (
        <div className="container-xl">
          <div className="table-responsive">
            <div className="table-wrapper">
                <EmployeeList tests={this.state.tests} />
            </div>
          </div>
        </div>
      );
}
}

export default ParentViewTest;