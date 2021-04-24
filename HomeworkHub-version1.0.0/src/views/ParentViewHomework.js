import React from "react";
import axios from "axios";

import EmployeeList from './components_homework_parent/EmployeeList';
import "./App.css";



class ParentViewHomework extends React.Component {

  constructor(props) {
    super(props);
    this.state={
      username: localStorage.getItem("parentusername"),
      classroomId: localStorage.getItem("parentclassroomId"),
      homeworks: []
    };

    this.getHomeworks = this.getHomeworks.bind(this);
    this.getHomeworks();
  }

  getHomeworks() {
    const url = "/HomeworkHub/backend/get_event_list.php";
      let formData = new FormData();
      let data = '{"classroomid":"' + this.state.classroomId + '", "type":"homework"}';
      //console.log(data);
      formData.append("formData", data);
      axios.post(url, formData)
      .then(response => {
        var res = response["data"];
        this.setState({homeworks: [...res]});
     })
     .catch(err=>console.log(err.response, err.request));
  }
  render() {
    
    
    return (
      <div className="container-xl">
        <div className="table-responsive">
          <div className="table-wrapper">
            <EmployeeList homeworks={this.state.homeworks} />
          </div>
        </div>
      </div>
    );
  }
}
export default ParentViewHomework;
