import React, { useState } from "react";
import axios from "axios";

import EmployeeList from './components_announcement_parent/EmployeeList';
import "./App.css";

class ParentViewAnnouncement extends React.Component {

    constructor(props) {
      super(props);
      this.state = {
        username: localStorage.getItem("parentusername"),
        classroomId: localStorage.getItem("parentclassroomId"),
        announcements: []
      }

      this.getAnnouncements = this.getAnnouncements.bind(this);
      this.getAnnouncements();
    }

    getAnnouncements() {
      const url = "/HomeworkHub/backend/get_event_list.php";
      let formData = new FormData();
      let data = '{"classroomid":"' + this.state.classroomId + '", "type":"announcement"}';
      //console.log(data);
      formData.append("formData", data);
      axios.post(url, formData)
      .then(response => {
        var res = response["data"];
        this.setState({announcements: [...res]});
     })
     .catch(err=>console.log(err.response, err.request));
    }
  
    render() {
      return (
        <div className="container-xl">
          <div className="table-responsive">
            <div className="table-wrapper">
                <EmployeeList announcements={this.state.announcements} />
            </div>
          </div>
        </div>
      );
}
}

export default ParentViewAnnouncement;